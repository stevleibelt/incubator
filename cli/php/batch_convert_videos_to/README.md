# Batch convert videos to

* converts list of video files to a specified format
* can convert multiple files at onces (multi threading)
* checks if the result is ok (old file size should be maximum 2.7 the size of the new one, else the new one is to small)
* removes source file if target file is looking good

# Command

```
batch_convert_video_to [--format=libx265|libx264] [--number-of-threads=1] [--list-of-files=*]
```

# Configuration

```
return [
    'default_settings   => [
        //each entry here can be overwritten by the supported format configuration section
        'remove_source_when_processing_was_succesful'   => true,
        'target_file_validator_chain' => [
            Validator\CompareSize::class    => [
                'diff' => 2.7
            ]
        ],
        'target_file_suffix'    => 'converted265.mkv'   //or hardcoded $format.mkv e.g. libx265.mkv
    ]
    'supported_format'  => [
        'libx264'   => [
            'command_to_call'   => ' ffmpeg -i "${SOURCE_FILE_PATH}" -map 0 -acodec copy -scodec copy -vcodec libx264 -nostats -hide_banner -pass 1 "${DESTINATION_FILE_PATH}" < /dev/null'
        ],
        'libx265'   => [
            'command_to_call'   => ' ffmpeg -i "${SOURCE_FILE_PATH}" -map 0 -acodec copy -scodec copy -vcodec libx265 -nostats -hide_banner -pass 1 "${DESTINATION_FILE_PATH}" < /dev/null'
        ]
    ]
]
```
