<?php

declare(strict_types=1);

/**
 * @copyright  2020 Ad Aures
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 * @link       https://castopod.org/
 */

return [
    'season' => 'Sæson {seasonNumber}',
    'season_abbr' => 'S{seasonNumber}',
    'number' => 'Episode {episodeNumber}',
    'number_abbr' => 'Ep. {episodeNumber}',
    'season_episode' => 'Sæson {seasonNumber} episode {episodeNumber}',
    'season_episode_abbr' => 'S{seasonNumber}:E{episodeNumber}',
    'persons' => '{personsCount, plural,
        one {# person}
        other {# personer}
    }',
    'persons_list' => 'Personer',
    'back_to_episodes' => 'Tilbage til episoderne af {podcast}',
    'comments' => 'Kommentarer',
    'activity' => 'Aktivitet',
    'description' => 'Episodebeskrivelse',
    'number_of_comments' => '{numberOfComments, plural,
        one {# kommentar}
        other {# kommentarer}
    }',
    'all_podcast_episodes' => 'Alle podcastepisoder',
    'back_to_podcast' => 'Tilbage til podcast',
    'preview' => [
        'title' => 'Preview',
        'not_published' => 'Not published',
        'text' => '{publication_status, select,
            published {This episode is not yet published.}
            scheduled {This episode is scheduled for publication on {publication_date}.}
            with_podcast {This episode will be published at the same time as the podcast.}
            other {This episode is not yet published.}
        }',
        'publish' => 'Publish',
        'publish_edit' => 'Edit publication',
    ],
];
