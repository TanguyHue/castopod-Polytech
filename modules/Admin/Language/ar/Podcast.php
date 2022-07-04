<?php

declare(strict_types=1);

/**
 * @copyright  2020 Ad Aures
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 * @link       https://castopod.org/
 */

return [
    'all_podcasts' => 'كافة البودكاستات',
    'no_podcast' => 'No podcast found!',
    'create' => 'إنشاء بودكاست',
    'import' => 'استيراد بودكاست',
    'new_episode' => 'حلقة جديدة',
    'view' => 'View podcast',
    'edit' => 'Edit podcast',
    'delete' => 'Delete podcast',
    'see_episodes' => 'See episodes',
    'see_contributors' => 'See contributors',
    'go_to_page' => 'الانتقال إلى الصفحة',
    'latest_episodes' => 'أحدث الحلقات',
    'see_all_episodes' => 'See all episodes',
    'messages' => [
        'createSuccess' => 'Podcast has been successfully created!',
        'editSuccess' => 'Podcast has been successfully updated!',
        'importSuccess' => 'Podcast has been successfully imported!',
        'deleteSuccess' => 'Podcast @{podcast_handle} successfully deleted!',
        'deletePodcastMediaError' => 'Failed to delete podcast {type, select,
            cover {cover}
            banner {banner}
            other {media}
        }.',
        'deleteEpisodeMediaError' => 'Failed to delete podcast episode {episode_slug} {type, select,
            transcript {transcript}
            chapters {chapters}
            image {cover}
            audio {audio}
            other {media}
        }.',
        'deletePodcastMediaFolderError' => 'Failed to delete podcast media folder {folder_path}. You may manually remove it from your disk.',
        'podcastFeedUpdateSuccess' => 'Successful update: {number_of_new_episodes, plural,
            one {# episode was}
            other {# episodes were}
        } added to the podcast!',
        'podcastFeedUpToDate' => 'Podcast is already up to date.',
        'podcastNotImported' => 'Podcast could not be updated as it was not imported.',
    ],
    'form' => [
        'identity_section_title' => 'Podcast identity',
        'identity_section_subtitle' => 'These fields allow you to get noticed.',
        'cover' => 'Podcast cover',
        'cover_size_hint' => 'Cover must be squared and at least 1400px wide and tall.',
        'banner' => 'Podcast banner',
        'banner_size_hint' => 'Banner must have a 3:1 ratio and be at least 1500px wide.',
        'banner_delete' => 'Delete podcast banner',
        'title' => 'العنوان',
        'handle' => 'Handle',
        'handle_hint' =>
            'Used to identify the podcast. Uppercase, lowercase, numbers and underscores are accepted.',
        'type' => [
            'label' => 'Type',
            'episodic' => 'Episodic',
            'episodic_hint' => 'If episodes are intended to be consumed without any specific order. Newest episodes will be presented first.',
            'serial' => 'Serial',
            'serial_hint' => 'If episodes are intended to be consumed in sequential order. The oldest episodes will be presented first.',
        ],
        'description' => 'الوصف',
        'classification_section_title' => 'Classification',
        'classification_section_subtitle' =>
            'These fields will impact your audience and competition.',
        'language' => 'اللغة',
        'category' => 'الفئة',
        'category_placeholder' => 'Select a category…',
        'other_categories' => 'Other categories',
        'parental_advisory' => [
            'label' => 'Parental advisory',
            'hint' => 'Does it contain explicit content?',
            'undefined' => 'undefined',
            'clean' => 'Clean',
            'explicit' => 'Explicit',
        ],
        'author_section_title' => 'Author',
        'author_section_subtitle' => 'Who is managing the podcast?',
        'owner_name' => 'Owner name',
        'owner_name_hint' =>
            'For administrative use only. Visible in the public RSS feed.',
        'owner_email' => 'Owner email',
        'owner_email_hint' =>
            'Will be used by most platforms to verify the podcast ownership. Visible in the public RSS feed.',
        'publisher' => 'Publisher',
        'publisher_hint' =>
            'The group responsible for creating the show. Often refers to the parent company or network of a podcast. This field is sometimes labeled as ’Author’.',
        'copyright' => 'حقوق التأليف',
        'location_section_title' => 'Location',
        'location_section_subtitle' => 'What place is this podcast about?',
        'location_name' => 'Location name or address',
        'location_name_hint' => 'This can be a real place or fictional',
        'monetization_section_title' => 'Monetization',
        'monetization_section_subtitle' =>
            'Earn money thanks to your audience.',
        'payment_pointer' => 'Payment Pointer for Web Monetization',
        'payment_pointer_hint' =>
            'This is your where you will receive money thanks to Web Monetization',
        'advanced_section_title' => 'الإعدادات المتقدمة',
        'advanced_section_subtitle' =>
            'If you need RSS tags that Castopod does not handle, set them here.',
        'custom_rss' => 'Custom RSS tags for the podcast',
        'custom_rss_hint' => 'This will be injected within the ❬channel❭ tag.',
        'new_feed_url' => 'New feed URL',
        'new_feed_url_hint' => 'Use this field when you move to another domain or podcast hosting platform. By default, the value is set to the current RSS URL if the podcast is imported.',
        'old_feed_url' => 'Old feed URL',
        'update_feed' => 'Update feed',
        'update_feed_tip' => 'Import this podcast\'s latest episodes',
        'partnership' => 'Partnership',
        'partner_id' => 'ID',
        'partner_link_url' => 'Link URL',
        'partner_image_url' => 'Image URL',
        'partner_id_hint' => 'Your own partner ID',
        'partner_link_url_hint' => 'The generic partner link address',
        'partner_image_url_hint' => 'The generic partner image address',
        'status_section_title' => 'Status',
        'block' => 'Podcast should be hidden from all platforms',
        'complete' => 'Podcast will not be having new episodes',
        'lock' => 'Prevent podcast from being copied',
        'lock_hint' =>
            'The purpose is to tell other podcast platforms whether they are allowed to import this feed. A value of yes means that any attempt to import this feed into a new platform should be rejected.',
        'submit_create' => 'Create podcast',
        'submit_edit' => 'Save podcast',
    ],
    'category_options' => [
        'uncategorized' => 'uncategorized',
        'arts' => 'Arts',
        'business' => 'Business',
        'comedy' => 'Comedy',
        'education' => 'Education',
        'fiction' => 'Fiction',
        'government' => 'Government',
        'health_and_fitness' => 'Health &amp Fitness',
        'history' => 'History',
        'kids_and_family' => 'Kids &amp Family',
        'leisure' => 'Leisure',
        'music' => 'موسيقى',
        'news' => 'أخبار',
        'religion_and_spirituality' => 'دين وروحانيات',
        'science' => 'علوم',
        'society_and_culture' => 'مجتمع وثقافة',
        'sports' => 'رياضة',
        'technology' => 'تكنولوجيا',
        'true_crime' => 'True Crime',
        'tv_and_film' => 'TV &amp Film',
        'books' => 'كتب',
        'design' => 'تصميم',
        'fashion_and_beauty' => 'أزياء وجمال',
        'food' => 'طعام',
        'performing_arts' => 'Performing Arts',
        'visual_arts' => 'Visual Arts',
        'careers' => 'Careers',
        'entrepreneurship' => 'Entrepreneurship',
        'investing' => 'Investing',
        'management' => 'Management',
        'marketing' => 'Marketing',
        'non_profit' => 'Non-Profit',
        'comedy_interviews' => 'Comedy Interviews',
        'improv' => 'Improv',
        'stand_up' => 'Stand-Up',
        'courses' => 'Courses',
        'how_to' => 'How To',
        'language_learning' => 'تعلم اللغات',
        'self_improvement' => 'تطوير الذات',
        'comedy_fiction' => 'Comedy Fiction',
        'drama' => 'Drama',
        'science_fiction' => 'Science Fiction',
        'alternative_health' => 'Alternative Health',
        'fitness' => 'Fitness',
        'medicine' => 'Medicine',
        'mental_health' => 'Mental Health',
        'nutrition' => 'Nutrition',
        'sexuality' => 'Sexuality',
        'education_for_kids' => 'Education for Kids',
        'parenting' => 'Parenting',
        'pets_and_animals' => 'Pets &amp Animals',
        'stories_for_kids' => 'Stories for Kids',
        'animation_and_manga' => 'Animation &amp Manga',
        'automotive' => 'Automotive',
        'aviation' => 'Aviation',
        'crafts' => 'Crafts',
        'games' => 'ألعاب',
        'hobbies' => 'هوايات',
        'home_and_garden' => 'المنزل والحديقة',
        'video_games' => 'ألعاب الفيديو',
        'music_commentary' => 'Music Commentary',
        'music_history' => 'Music History',
        'music_interviews' => 'Music Interviews',
        'business_news' => 'Business News',
        'daily_news' => 'Daily News',
        'entertainment_news' => 'Entertainment News',
        'news_commentary' => 'News Commentary',
        'politics' => 'سياسة',
        'sports_news' => 'أخبار رياضية',
        'tech_news' => 'أخبار التكنولوجيا',
        'buddhism' => 'Buddhism',
        'christianity' => 'Christianity',
        'hinduism' => 'Hinduism',
        'islam' => 'إسلام',
        'judaism' => 'يهودية',
        'religion' => 'دين',
        'spirituality' => 'روحانيات',
        'astronomy' => 'علم الفلك',
        'chemistry' => 'كيمياء',
        'earth_sciences' => 'علوم الأرض',
        'life_sciences' => 'علوم الحياة',
        'mathematics' => 'الرياضيات',
        'natural_sciences' => 'العلوم الطبيعية',
        'nature' => 'الطبيعة',
        'physics' => 'الفيزياء',
        'social_sciences' => 'العلوم الاجتماعية',
        'documentary' => 'وثائقي',
        'personal_journals' => 'يوميات شخصية',
        'philosophy' => 'الفلسفة',
        'places_and_travel' => 'Places &amp Travel',
        'relationships' => 'العلاقات',
        'baseball' => 'Baseball',
        'basketball' => 'كرة السلة',
        'cricket' => 'الكريكيت',
        'fantasy_sports' => 'Fantasy Sports',
        'football' => 'كرة القدم',
        'golf' => 'الغولف',
        'hockey' => 'الهوكي',
        'rugby' => 'Rugby',
        'running' => 'Running',
        'soccer' => 'كرة القدم',
        'swimming' => 'السباحة',
        'tennis' => 'Tennis',
        'volleyball' => 'الكرة الطائرة',
        'wilderness' => 'Wilderness',
        'wrestling' => 'Wrestling',
        'after_shows' => 'After Shows',
        'film_history' => 'Film History',
        'film_interviews' => 'Film Interviews',
        'film_reviews' => 'Film Reviews',
        'tv_reviews' => 'TV Reviews',
    ],
    'delete_form' => [
        'disclaimer' =>
            "Deleting the podcast will delete all episodes, media files, posts and analytics associated with it. This action is irreversible, you will not be able to retrieve them afterwards.",
        'understand' => 'I understand, I want the podcast to be permanently deleted',
        'submit' => 'Delete',
    ],
    'by' => 'By {publisher}',
    'season' => 'Season {seasonNumber}',
    'list_of_episodes_year' => '{year} episodes ({episodeCount})',
    'list_of_episodes_season' =>
        'Season {seasonNumber} episodes ({episodeCount})',
    'no_episode' => 'No episode found!',
    'follow' => 'Follow',
    'followers' => '{numberOfFollowers, plural,
        one {# follower}
        other {# followers}
    }',
    'posts' => '{numberOfPosts, plural,
        one {# post}
        other {# posts}
    }',
    'activity' => 'Activity',
    'episodes' => 'الحلقات',
    'sponsor' => 'الراعي',
    'funding_links' => 'Funding links for {podcastTitle}',
    'find_on' => 'Find {podcastTitle} on',
    'listen_on' => 'Listen on',
];
