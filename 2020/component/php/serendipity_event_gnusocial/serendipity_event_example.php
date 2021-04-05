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

const SERENDIPITY_EVENT_HELLOWORLD_VERSION = '0.0.1';

/**
 * serendipity_property_bag::add($key, $value)
 * serendipity_property_bag::get($key) : mixed
 * serendipity_property_bag::is_set($key) : bool
 *
 * available propbag types:
 *  string
 *  boolean
 *  text
 *  radio
 *  tristate
 *  select
 *  multiselect
 *  html
 *
 * available propbag validators [optional]:
 *  string
 *  words
 *  number
 *  url
 *  mail
 *  path
 *
 * available plugins:
 *  css
 *  frontend_configure
 *  entry_display
 *  entries_header
 *  entries_footer
 *  frontend_header
 *  frontend_footer
 *  entry_groupdata
 *  comments by author footer
 *  frontend fetchentries
 *  frontend fetchentry
 *  frontend entryproperties
 *  frontend entryproperties query
 *  fetchcomments
 *  frontend_display
 *  frontend_display_cache
 *  frontend_comment
 *  frontend_rss
 *  frontend_entries_rss
 *  frontend_saveComment
 *  frontend_generate_plugins
 *  quickserch_plugin
 *  frontend_image_selector
 *  external_plugin
 *  genpage
 *  frontend_calendar
 *  frontend xmlrpc
 *  ...
 *  backend delete entry
 *  backend_preview
 *  backend_publish
 *  backend_save
 *  backend_display
 *  backend_entryform
 *  ...
 */

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
            'Event-Plugin: Example!'
        );
		$propertyBag->add(
            'description',
            'Event-Plugin: Description'
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
                'headline',
                'pagetitle'
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
     * @param string $eventName
     * @param serendipity_property_bag $propertyBag
     * @return bool
     */
	public function introspect_config_item($eventName, &$propertyBag)
    {
        global $serendipity;

        switch($eventName) {
            case 'headline':
                $propertyBag->add('type', 'string');
                $propertyBag->add('name', 'page title');
                $propertyBag->add('description', '');
                $propertyBag->add('default', 'example title');
                $propertyBag->add('validate', 'string');
                break;
            case 'pagetitle':
                $propertyBag->add('type', 'string');
                $propertyBag->add('name', 'url variable');
                $propertyBag->add('description', '');
                $propertyBag->add('default', 'example');
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
        global $serendipity;    //why?

        $hooks          = &$bag->get('event_hooks');
        $hookIsValid    = (isset($hooks[$eventName]));
        $hookProcessed  = false;

        if ($hookIsValid) {
            switch($eventName) {
                case 'entry_display':
                    if ($this->selected()) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true;
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }
                    $hookProcessed = true;
                    break;
                case 'entries_header':
                    $this->show();
                    $hookProcessed = true;
                    break;
                default:
                    break;
            }
        }

        return $hookProcessed;
	}

    /**
     * helper method to keep event_hook as dry as possible
     */
	private function show()
    {
        global $serendipity;

        if ($this->selected()) {
            if (!headers_sent()) {
                header('HTTP/1.0 200');
            }

            $serendipity['smarty']->assign('staticpage_pagetitle',
            preg_replace('@[ˆa-z0-9]@i', '_',
            $this->get_config('pagetitle')));

            echo '<h4 class=\'serendipity_title\'><a href=\'#\'>' . $this->get_config('headline') . '</a></h4>';
            echo '<div>please give me an: oh!</div>';
        }
	}

    /**
     * helper method to keep event_hook as dry as possible
     * @return bool
     */
	private function selected()
    {
        global $serendipity;

        if ($serendipity['GET']['subpage'] == $this->get_config('pagetitle') || preg_match('@ˆ' . preg_quote($this->get_config('permalink')) . '@i', $serendipity['GET']['subpage'])) {
            return true;
        }

        return false;
	}
}
