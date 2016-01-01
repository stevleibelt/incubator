<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-01-01
 */

if (IN_serendipity !== true) {
	die ('Don\'t hack!');
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$currentLanguageFilePath = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';

if (file_exists($currentLanguageFilePath)) {
    include $currentLanguageFilePath;
}

require_once dirname(__FILE__) . '/lang_en.inc.php';

@define('PLUGIN_EVENT_GNUSOCIAL_VERSION', '0.0.1');

/**
 * Class serendipity_event_helloworld
 */
final class serendipity_event_helloworld extends serendipity_event
{
    /**
     * setup on which event we are looking at
     * @param serendipity_property_bag $propertyBag
     */
	public function introspect(&$propertyBag)
	{
        /** array */
		global $serendipity;

		$propertyBag->add(
            'name',
            PLUGIN_EVENT_GNUSOCIAL_NAME
        );
		$propertyBag->add(
            'description',
            PLUGIN_EVENT_GNUSOCIAL_NAME_DESCRIPTION
        );
		$propertyBag->add(
            'event_hooks',
            array(
                'entries_header' => true,
		        'entry_display' => true
            )
        );
		$propertyBag->add(
            'configuration',
            array(
                'feed_url',
                'username',
                'password'
            )
        );
		$propertyBag->add(
            'author',
            'Jon Doh'
        );
		$propertyBag->add(
            'version',
            SERENDIPITY_EVENT_HELLOWORLD_VERSION
        );
		$propertyBag->add(
            'requirements',
            array(
		        'serendipity'   => '1.7',
		        'smarty'        => '2.6.7',
		        'php'           => '5.3.0'
		    )
        );
		$propertyBag->add(
            'groups',
            array(
                'FRONTEND_EXTERNAL_SERVICES'
            )
        );
		$propertyBag->add(
            'stackable',
            true
        );
	}

    /**
     * setup you plugin with needed configuration values
     * @param string $name
     * @param serendipity_property_bag $propertyBag
     * @return bool
     */
	public function introspect_config_item($name, &$propertyBag)
    {
        global $serendipity;

        switch($name) {
            case 'password':
                $propertyBag->add('type', 'string');
                $propertyBag->add('name', 'password');
                $propertyBag->add('description', PLUGIN_EVENT_GNUSOCIAL_PROPERTY_PASSWORD_DESCRIPTION);
                $propertyBag->add('default', 'parola!');
                break;
            case 'username':
                $propertyBag->add('type', 'string');
                $propertyBag->add('name', 'username');
                $propertyBag->add('description', PLUGIN_EVENT_GNUSOCIAL_PROPERTY_USER_NAME_DESCRIPTION);
                $propertyBag->add('default', 'jondoh@gnusocial.net');
                break;
            case 'url':
                $propertyBag->add('type', 'string');
                $propertyBag->add('name', 'url');
                $propertyBag->add('description', PLUGIN_EVENT_GNUSOCIAL_PROPERTY_URL_DESCRIPTION);
                $propertyBag->add('default', 'https://gnusocial.net');
                break;
            default:
                return false;
        }

        return true;
	}

    /**
     * THE plugin method (aka dispatcher), called for each available event hook
     * @param string $eventName
     * @param $bag
     * @param null|array $eventData
     * @param null $addData
     * @return bool
     */
	public function event_hook($eventName, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks          = &$bag->get('event_hooks');
        $hookIsValid    = (isset($hooks[$eventName]));
        $hookProcessed  = false;

        if ($hookIsValid) {
            switch($eventName) {
                case 'backend_publish':
                    $isNewEntry         = ($addData === true);
                    $eventDataIsValid   = (
                        is_array($eventData)
                        && isset($eventData['id'])
                        && isset($eventData['title'])
                    );
                    $publishEntry       = (
                        $isNewEntry
                        && $eventDataIsValid
                    );

                    if ($publishEntry) {
                        $baseUrl    = $serendipity['baseURL'];
                        $headLine   = $eventData['title'];
                        $id         = $eventData['id'];
                        $password   = $this->get_config('password');
                        $userName   = $this->get_config('user_name');
                        $url        = $this->get_config('url');

                        $this->publish($headLine, $id, $password, $userName, $url);
                    }

                    $hookProcessed = true;
                    break;
                default:
                    break;
            }
        }

        return $hookProcessed;
	}

    /**
     * @todo implement error handling if resource is not available or status code is >= 400
     * @param string $baseUrl
     * @param string $headLine
     * @param int $id
     * @param string $password
     * @param string $userName
     * @param string $url
     */
    private function publish($baseUrl, $headLine, $id, $password, $userName, $url)
    {
        $content    = $headLine . '<br /><br />' . $baseUrl . '/' .  $id . '-' . urlencode($headLine) . '.html';
        $data       = '{status: ' . $content . ', source: serendipity_event_gnusocial}';
        $handler    = curl_init($url . '/api/statusnet/update.xml');

        curl_setopt_array(
            $handler,
            array(
                CURLINFO_HEADER_OUT     => false,
                CURLOPT_RETURNTRANSFER  => false,
                CURLOPT_POST            => true,
                CURLOPT_POSTFIELDS      => $data,
                CURLOPT_USERPWD         => $userName . ':' . $password
            )
        );

        curl_exec($handler);
    }
}