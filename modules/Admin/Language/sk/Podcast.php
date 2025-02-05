<?php

declare(strict_types=1);

/**
 * @copyright  2020 Ad Aures
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 * @link       https://castopod.org/
 */

return [
    'all_podcasts' => 'Všetky podcasty',
    'no_podcast' => 'Žiadny podcast nenájdený!',
    'create' => 'Vytvoriť podcast',
    'import' => 'Importovať podcast',
    'all_imports' => 'Podcast imports',
    'new_episode' => 'Nová časť',
    'view' => 'Zobraziť podcast',
    'edit' => 'Upraviť podcast',
    'publish' => 'Zverejniť podcast',
    'publish_edit' => 'Upraviť zverejnené',
    'delete' => 'Vymazať podcast',
    'see_episodes' => 'Ukázať časti',
    'see_contributors' => 'Pozrieť prispievateľov',
    'monetization_other' => 'Other monetization',
    'go_to_page' => 'Prejsť na stránku',
    'latest_episodes' => 'Posledné časti',
    'see_all_episodes' => 'Pozrieť všetky časti',
    'draft' => 'Koncept',
    'messages' => [
        'createSuccess' => 'Podcast úspešne vytvorený!',
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
        'podcastFeedUpToDate' => 'Podcast už je aktualizovaný.',
        'publishError' => 'This podcast is either already published or scheduled for publication.',
        'publishEditError' => 'This podcast is not scheduled for publication.',
        'publishCancelSuccess' => 'Podcast publication successfully cancelled!',
        'scheduleDateError' => 'Schedule date must be set!',
    ],
    'form' => [
        'identity_section_title' => 'Identita podcastu',
        'identity_section_subtitle' => 'These fields allow you to get noticed.',
        'fediverse_section_title' => 'Identita vo Fediverse',

        'cover' => 'Obal podcastu',
        'cover_size_hint' => 'Obrázok musí byť štvorcový a minimálne 1400px široký a vysoký.',
        'banner' => 'Podcast banner',
        'banner_size_hint' => 'Banner must have a 3:1 ratio and be at least 1500px wide.',
        'banner_delete' => 'Delete podcast banner',
        'title' => 'Názov',
        'handle' => 'Handle',
        'handle_hint' =>
            'Used to identify the podcast. Uppercase, lowercase, numbers and underscores are accepted.',
        'type' => [
            'label' => 'Typ',
            'episodic' => 'Epizodický',
            'episodic_hint' => 'If episodes are intended to be consumed without any specific order. Newest episodes will be presented first.',
            'serial' => 'Serial',
            'serial_hint' => 'If episodes are intended to be consumed in sequential order. The oldest episodes will be presented first.',
        ],
        'description' => 'Popis',
        'classification_section_title' => 'Zaradenie',
        'classification_section_subtitle' =>
            'These fields will impact your audience and competition.',
        'language' => 'Jazyk',
        'category' => 'Kategória',
        'category_placeholder' => 'Vybrať kategóriu…',
        'other_categories' => 'Ostatné kategórie',
        'parental_advisory' => [
            'label' => 'Parental advisory',
            'hint' => 'Obsahuje explicitný obsah?',
            'undefined' => 'neuvedené',
            'clean' => 'Čistá',
            'explicit' => 'Chúlostivé',
        ],
        'author_section_title' => 'Autor',
        'author_section_subtitle' => 'Kto spravuje tento podcast?',
        'owner_name' => 'Meno vlastníka',
        'owner_name_hint' =>
            'For administrative use only. Visible in the public RSS feed.',
        'owner_email' => 'Email vlastníka',
        'owner_email_hint' =>
            'Will be used by most platforms to verify the podcast ownership. Visible in the public RSS feed.',
        'is_owner_email_removed_from_feed' => 'Remove the owner email from the public RSS feed',
        'is_owner_email_removed_from_feed_hint' => 'You may need to temporarily unhide the email so that a directory can verify your podcast ownership.',
        'publisher' => 'Vydavateľ',
        'publisher_hint' =>
            'The group responsible for creating the show. Often refers to the parent company or network of a podcast. This field is sometimes labeled as ’Author’.',
        'copyright' => 'Autorské práva',
        'location_section_title' => 'Umiestnenie',
        'location_section_subtitle' => 'O akom mieste/oblasti je tento podcast?',
        'location_name' => 'Názov oblasti, alebo adresa',
        'location_name_hint' => 'This can be a real place or fictional',
        'monetization_section_title' => 'Monetization',
        'monetization_section_subtitle' =>
            'Earn money thanks to your audience.',
        'premium' => 'Prémiový obsah',
        'premium_by_default' => 'Epizódy musia byť predvolene nastavené ako prémiové',
        'premium_by_default_hint' => 'Podcast episodes will be marked as premium by default. You can still choose to set some episodes, trailers or bonuses as public.',
        'op3' => 'Open Podcast Prefix Project (OP3)',
        'op3_link' => 'Visit your OP3 dashboard (external link)',
        'op3_hint' => 'Value your analytics data with OP3, an open-source and trusted third party analytics service. Share, validate and compare your analytics data with the open podcasting ecosystem.',
        'op3_enable' => 'Enable OP3 analytics service',
        'op3_enable_hint' => 'For security reasons, premium episodes\' analytics data will not be shared with OP3.',
        'payment_pointer' => 'Payment Pointer for Web Monetization',
        'payment_pointer_hint' =>
            'This is your where you will receive money thanks to Web Monetization',
        'advanced_section_title' => 'Advanced Parameters',
        'advanced_section_subtitle' =>
            'If you need RSS tags that Castopod does not handle, set them here.',
        'custom_rss' => 'Custom RSS tags for the podcast',
        'custom_rss_hint' => 'This will be injected within the ❬channel❭ tag.',
        'new_feed_url' => 'New feed URL',
        'new_feed_url_hint' => 'Use this field when you move to another domain or podcast hosting platform. By default, the value is set to the current RSS URL if the podcast is imported.',
        'old_feed_url' => 'Old feed URL',
        'partnership' => 'Partnerstvo',
        'partner_id' => 'ID',
        'partner_link_url' => 'URL adresa odkazu',
        'partner_image_url' => 'URL adresa obrázka',
        'partner_id_hint' => 'Your own partner ID',
        'partner_link_url_hint' => 'The generic partner link address',
        'partner_image_url_hint' => 'The generic partner image address',
        'block' => 'Podcast should be hidden from public catalogues',
        'block_hint' =>
            'The podcast show or hide status: toggling this on prevents the entire podcast from appearing in Apple Podcasts, Google Podcasts, and any third party apps that pull shows from these directories. (Not guaranteed)',
        'complete' => 'Podcast will not be having new episodes',
        'lock' => 'Prevent podcast from being copied',
        'lock_hint' =>
            'The purpose is to tell other podcast platforms whether they are allowed to import this feed. A value of yes means that any attempt to import this feed into a new platform should be rejected.',
        'submit_create' => 'Vytvoriť podcast',
        'submit_edit' => 'Uložiť podcast',
    ],
    'category_options' => [
        'uncategorized' => 'nezaradený',
        'arts' => 'Umenia',
        'business' => 'Podnikanie',
        'comedy' => 'Komédia',
        'education' => 'Vzdelanie',
        'fiction' => 'Fikcia',
        'government' => 'Štátna správa',
        'health_and_fitness' => 'Zdravie a fitnes',
        'history' => 'História',
        'kids_and_family' => 'Kids &amp Family',
        'leisure' => 'Voľný čas',
        'music' => 'Hudba',
        'news' => 'Správy',
        'religion_and_spirituality' => 'Religion &amp Spirituality',
        'science' => 'Veda',
        'society_and_culture' => 'Spoločnosť a kultúra',
        'sports' => 'Športy',
        'technology' => 'Technológia',
        'true_crime' => 'Skutočné krimi',
        'tv_and_film' => 'TV &amp Film',
        'books' => 'Knihy',
        'design' => 'Dizajn',
        'fashion_and_beauty' => 'Fashion &amp Beauty',
        'food' => 'Jedlo',
        'performing_arts' => 'Divadelné umenie',
        'visual_arts' => 'Vizuálni umelci',
        'careers' => 'Kariéra',
        'entrepreneurship' => 'Podnikateľský',
        'investing' => 'Investičný',
        'management' => 'Manažment',
        'marketing' => 'Marketing',
        'non_profit' => 'Neziskový',
        'comedy_interviews' => 'Komediálne rozhovory',
        'improv' => 'Improv',
        'stand_up' => 'Stand-Up',
        'courses' => 'Kurzy',
        'how_to' => 'Ako na to',
        'language_learning' => 'Učenie jazykov',
        'self_improvement' => 'Sebazdokonaľovanie',
        'comedy_fiction' => 'Comedy Fiction',
        'drama' => 'Dráma',
        'science_fiction' => 'Vedecko-fantastické',
        'alternative_health' => 'Alternative Health',
        'fitness' => 'Fitness',
        'medicine' => 'Medicínsky',
        'mental_health' => 'Duševné zdravie',
        'nutrition' => 'Nutrition',
        'sexuality' => 'Sexualita',
        'education_for_kids' => 'Vzdelávanie pre deti',
        'parenting' => 'Rodičovstvo',
        'pets_and_animals' => 'Pets &amp Animals',
        'stories_for_kids' => 'Príbehy pre deti',
        'animation_and_manga' => 'Animation &amp Manga',
        'automotive' => 'Automotive',
        'aviation' => 'Aviation',
        'crafts' => 'Crafts',
        'games' => 'Hry',
        'hobbies' => 'Záľuby',
        'home_and_garden' => 'Home &amp Garden',
        'video_games' => 'Videohry',
        'music_commentary' => 'Music Commentary',
        'music_history' => 'Hudobná história',
        'music_interviews' => 'Hudobné rozhovory',
        'business_news' => 'Business News',
        'daily_news' => 'Denné správy',
        'entertainment_news' => 'Entertainment News',
        'news_commentary' => 'News Commentary',
        'politics' => 'Politika',
        'sports_news' => 'Športové správy',
        'tech_news' => 'Technologické novinky',
        'buddhism' => 'Buddhism',
        'christianity' => 'Kresťanstvo',
        'hinduism' => 'Hinduizmus',
        'islam' => 'Islam',
        'judaism' => 'Judaism',
        'religion' => 'Náboženstvo',
        'spirituality' => 'Duchovno',
        'astronomy' => 'Astronómia',
        'chemistry' => 'Chémia',
        'earth_sciences' => 'Earth Sciences',
        'life_sciences' => 'Life Sciences',
        'mathematics' => 'Matematické',
        'natural_sciences' => 'Natural Sciences',
        'nature' => 'Príroda',
        'physics' => 'Fyzika',
        'social_sciences' => 'Sociálne vedy',
        'documentary' => 'Dokumentárny',
        'personal_journals' => 'Personal Journals',
        'philosophy' => 'Filozofia',
        'places_and_travel' => 'Places &amp Travel',
        'relationships' => 'Vzťahy',
        'baseball' => 'Bejzbal',
        'basketball' => 'Basketball',
        'cricket' => 'Cricket',
        'fantasy_sports' => 'Fantasy Sports',
        'football' => 'Futbal',
        'golf' => 'Golf',
        'hockey' => 'Hockey',
        'rugby' => 'Rugby',
        'running' => 'Running',
        'soccer' => 'Futbal',
        'swimming' => 'Plávanie',
        'tennis' => 'Tenis',
        'volleyball' => 'Volejbal',
        'wilderness' => 'Divočina',
        'wrestling' => 'Zápasnícky',
        'after_shows' => 'After Shows',
        'film_history' => 'Filmová história',
        'film_interviews' => 'Filmové rozhovory',
        'film_reviews' => 'Filmové recenzie',
        'tv_reviews' => 'TV recenzie',
    ],
    'publish_form' => [
        'back_to_podcast_dashboard' => 'Späť na podcastovú nástenku',
        'post' => 'Váš oznamovací príspevok',
        'post_hint' =>
            "Write a message to announce the publication of your podcast. The message will be featured in your podcast's homepage.",
        'message_placeholder' => 'Napíšte vašu správu…',
        'submit' => 'Zverejniť',
        'publication_date' => 'Dátum zverejnenia',
        'publication_method' => [
            'now' => 'Hneď teraz',
            'schedule' => 'Naplánovať',
        ],
        'scheduled_publication_date' => 'Dátum plánovaného zverejnenia',
        'scheduled_publication_date_hint' =>
            'You can schedule the podcast release by setting a future publication date. This field must be formatted as YYYY-MM-DD HH:mm',
        'submit_edit' => 'Upraviť zverejnenie',
        'cancel_publication' => 'Zrušiť zverejnenie',
        'message_warning' => 'You did not write a message for your announcement post!',
        'message_warning_hint' => 'Having a message increases social engagement, resulting in a better visibility for your podcast.',
        'message_warning_submit' => 'Napriek tomu zverejniť',
    ],
    'publication_status_banner' => [
        'draft_mode' => 'konceptový režim',
        'not_published' => 'Tento podcast ešte nieje zverejnený.',
        'scheduled' => 'This podcast is scheduled for publication on {publication_date}.',
    ],
    'delete_form' => [
        'disclaimer' =>
            "Deleting the podcast will delete all episodes, media files, posts and analytics associated with it. This action is irreversible, you will not be able to retrieve them afterwards.",
        'understand' => 'I understand, I want the podcast to be permanently deleted',
        'submit' => 'Vymazať',
    ],
    'by' => 'Od {publisher}',
    'season' => 'Season {seasonNumber}',
    'list_of_episodes_year' => '{year} episodes ({episodeCount})',
    'list_of_episodes_season' =>
        'Season {seasonNumber} episodes ({episodeCount})',
    'no_episode' => 'Žiadna epizóda nenájdená!',
    'follow' => 'Nasledovať',
    'followers' => '{numberOfFollowers, plural,
        one {# follower}
        other {# followers}
    }',
    'posts' => '{numberOfPosts, plural,
        one {# post}
        other {# posts}
    }',
    'activity' => 'Aktivita',
    'episodes' => 'Časti',
    'sponsor' => 'Sponzor',
    'funding_links' => 'Odkazy na financovanie {podcastTitle}',
    'find_on' => 'Nájsť {podcastTitle} na',
    'listen_on' => 'Počúvajte na',
];
