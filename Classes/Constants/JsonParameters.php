<?php

namespace KURZ\KurzFlowplayer\Constants;
//Get Video RESPONSE SCHEMA: application/json

class JsonParameters
{
    //string
    // The Video name, can be displayed in the player. If not specified, it will default to the input files name.
    const NAME = 'name';

    //string
    // The Video description, can be displayed in the player.
    const DESCRIPTION = 'description';

    //integer <int64>
    const DURATION = 'duration';

    //boolean
    // Default: false If true the unpublish_date is respected and the video will not be available after unpublish_date. If false the video will not be unpublished.
    const UNPUBLISH = 'unpublish';

    //string
    // Date and time in ISO 8601 format when video no longer is available for publishing. After this date the video is not visible in the player if using ovp-plugin to request the video.
    const UNPUBLISH_DATE = 'unpublish_date';

    //boolean
    //  This field, together with pubish_date and unpublish_date, determines if this Video will be visible in public listings such as MRSS-feeds, endscreens and Playlists. If true and publish_date and unpublish_date allows, the Video will be visible.
    const PUBLISHED = 'published';

    //string
    // Date and time in ISO 8601 format when video is available for publishing . Before this date the video is not visible in the player if using ovp-plugin to request the video.
    const PUBLISH_DATE = 'publish_date';

    //string
    // A comma separated list of tags
    const TAGS = 'tags';

    // boolean
    // Default: false When set to true the Video is treated as a remote asset by the platform
    const REMOTE = 'remote';

    // Array of objects (CustomField)
    //  key => value
    const CUSTOM_FIELDS = 'custom_fields';

    // object (IdNameResponseCategory)
    const CATEGORY = 'category';

    //string
    // Default: "<The Workspace default Category>" The unique identifier for the Category that the Video belongs to.
    const CATEGORY_ID = 'category_id';

    //boolean
    // When set to true no ads will be displayed during this Video. Notice, this feature only works for Iframe embeds.
    const NO_ADS = 'no_ads';

    //string
    // Used for replacing the ad_keywords macro in the VAST-tag in any Player that plays the Video
    const AD_KEYWORDS = 'ad_keywords';

    // object (IdNameResponseWorkspaceSimple)
    // id => name
    const WORKSPACE = 'workspace';

    //string
    // Id for the creator of the Video
    const USER_ID = 'user_id';

    // Array of objects (ChapterDTO)
    // The video chapters
    const CHAPTERS = 'chapters';

    // string
    // Unique identifier for the Video
    const ID = 'id';

    //string
    // The creation date for the Video in ISO 8601 format. For example: 2020-01-01T12:33:22+00:00
    const CREATED_AT = 'created_at';

    //string
    // The update date for the Video in ISO 8601 format. For example: 2020-01-01T12:33:22+00:00
    const UPDATED_AT = 'updated_at';

    //string
    // The current state of the Video. The state reflects the current status of the video files for the Video asset.
    const STATE = 'state';

    //number <double>
    // Progress of video encoding in percentage. The max value, 100, is reach when all video files have been encoded.
    const ENCODING_PROGRESS = 'encoding_progress';

    //number <double>
    // Progress of source file upload in percentage. If value is 100 the source file is uploaded.
    const UPLOAD_PROGRESS = 'upload_progress';

    //string
    // If the platform failed to encode the source file, a message describing the error reason will be presented in this property.
    const ERROR_MESSAGE = 'error_message';


    //boolean
    // Default: false If true this Video has been deactivated and is no longer available for embedding. This usually happens if the account was cancelled or trial limits were exceeded.
    const deactivated = 'deactivated';

    /*Array of objects (Image)
    Images used together with the Video in the platform and the player.
    For platform Video images specified in create and update requests, these are uploaded and delivered through the platform. For remote assets the specified image urls are just passed along to the player using the url specified in the request.*/
    const IMAGES = 'images';


    /*string
    Enum: "thumbnail" "image" "image_0" "image_1" "image_2" "image_3" "image_4" "image_5"
    Image type where valid values are thumbnail or image. thumbnail is a smaller image and image is larger. Size of the images depends on the size of the uploaded image.*/

    const IMAGE_TYPE_THUMBNAIL = 'thumbnail';
    const IMAGE_TYPE_image = 'image';
    const IMAGE_TYPE_image_0 = 'image_0';
    const IMAGE_TYPE_image_1 = 'image_1';
    const IMAGE_TYPE_image_2 = 'image_2';
    const IMAGE_TYPE_image_3 = 'image_3';
    const IMAGE_TYPE_image_4 = 'image_4';
    const IMAGE_TYPE_image_5 = 'image_5';


    /*Array of objects (Encoding)
    Array containing all available Video files and their metadata*/
    const ENCODINGS = 'encodings';


    //integer <int32>
    // Audio bitrate in kb/s.
    const ENCODING_AUDIO_BITRATE = 'audio_bitrate';

    // integer <int32>
    // Number of audio channel.
    const ENCODING_AUDIO_CHANNEL = 'audio_channel';

    // string
    // Audio codec used in the file.
    const ENCODING_AUDIO_CODEC = 'audio_channel';

    //integer <int32>
    // bitrate
    const BITRATE = 'bitrate';

    // integer <int32>
    // Total bitrate, video+audio, for the file in kb/s
    const ENCODING_AUDIO_SAMPLE_RATE = 'audio_sample_rate';

    // string
    // Creation timestamp of the file
    const ENCODING_CREATED = 'created';

    //string
    const ENCODING_FORMAT = 'format';

    // string integer <int32>
    // Height of the Video in pixels
    const ENCODING_HEIGHT = 'height';

    //integer <int32>
    // Width of the Video in pixels
    const ENCODING_WIDTH = 'width';

    //integer <int64>
    // Total file size including both audio and video in bytes. For segmented files, such as DASH and HLS, this is the complete size covering all segments and renditions.
    const ENCODING_SIZE = 'size';

    //string
    // Https-link to the video file
    const ENCODING_VIDEO_FILE_URL = 'video_file_url';

    //string
    // Video container type used for this Video file.
    const ENCODING_VIDEO_FORMAT = 'video_format';

    //string
    // Video codec used in this Video file.
    const ENCODING_VIDEO_CODEC = 'video_codec';

    //Array of objects (Subtitle)
    // List with all subtitles uploaded for this Video asset.
    const SUBTITLES = 'subtitles';

    //object (DRM)
    // Contains all DRM configurations
    const DRM = 'drm';

    /*boolean
    Whether this Video is a shallow copy of another Video. A shallow copy uses Video files controlled by another Video, usually on another Workspace.
    Video that are shallow copies can't use all features available for normal Videos. For example, it's not possible to upload a new version of the video.
    Another difference is that deleting the Video will not delete any Video files. If the Video asset that is the source of the copy is deleted, the files will no longer be available for this asset.*/
    const SHALLOW_COPY = 'shallow_copy';

    //boolean
    // If true, this video has several different audio tracks available for the player. For example, there may be audio tracks in different languages.
    const MULTIPLE_AUDIO_TRACKS = 'multiple_audio_tracks';

    //boolean
    // If true, this video has no video track but only audio tracks.
    const AUDIO_ONLY = 'audio_only';

    //string
    // This property tells how the Video asset was added to the platform. Following values are available:
    const UPLOAD_TYPE = 'upload_type';

    //integer <int32>
    //Version tracks the number of times a new source file was uploaded for this Video asset. For each time a new source file is uploaded, the value increases by one.
    const VERSION = 'version';


}
