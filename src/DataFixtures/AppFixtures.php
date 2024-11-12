<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Episode;
use App\Entity\Language;
use App\Entity\Media;
use App\Entity\Movie;
use App\Entity\Playlist;
use App\Entity\PlaylistMedia;
use App\Entity\PlaylistSubscription;
use App\Entity\Season;
use App\Entity\Serie;
use App\Entity\Subscription;
use App\Entity\SubscriptionHistory;
use App\Entity\User;
use App\Entity\WatchHistory;
use App\Enum\CommentsStatusEnum;
use App\Enum\MediaTypeEnum;
use App\Enum\UserStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private \Faker\Generator $faker;
    private $dataToPersist = [];

    public function load(ObjectManager $manager): void
    {
        $this->faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $this->createCategory();
        }

        for ($i = 0; $i < 10; $i++) {
            $this->createUser();
        }

        foreach ($this->dataToPersist as $entity) {
            $manager->persist($entity);
        }

        $manager->flush();
    }

    private $subscriptions = [];
    private function getSubscriptions(): array
    {
        if (empty($this->subscriptions)) {
            $subscription = new Subscription();
            $subscription->setName('Free');
            $subscription->setPrice(0);
            $subscription->setDurationInMonths(1);
            $subscription->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-5 year', 'now')));
            $this->subscriptions[] = $subscription;

            $subscription = new Subscription();
            $subscription->setName('Premium');
            $subscription->setPrice(9.99);
            $subscription->setDurationInMonths(1);
            $subscription->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-5 year', 'now')));
            $this->subscriptions[] = $subscription;

            $subscription = new Subscription();
            $subscription->setName('Premium Plus');
            $subscription->setPrice(14.99);
            $subscription->setDurationInMonths(1);
            $subscription->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-5 year', 'now')));
            $this->subscriptions[] = $subscription;

            foreach ($this->subscriptions as $subscription) {
                $this->dataToPersist[] = $subscription;
            }
        }

        return $this->subscriptions;
    }

    private function createUser(): User
    {
        $user = new User();
        $user->setEmail($this->faker->email());
        $user->setPassword($this->faker->password());
        $user->setStatus($this->faker->randomElement(UserStatusEnum::cases()));
        $user->setUsername($this->faker->userName());
        $subscriptions = $this->getSubscriptions();
        $user->setSubscription($subscriptions[$this->faker->numberBetween(0, count($subscriptions) - 1)]);

        $this->dataToPersist[] = $user;

        $userSubscriptionHistories = $this->createUserSubscriptionHistory();
        foreach ($userSubscriptionHistories as $userSubscriptionHistory) {
            $user->setSubscriptionHistory($userSubscriptionHistory);
            $userSubscriptionHistory->setSubscriber($user);
        }
    
        for ($i = 0; $i < $this->faker->numberBetween(0, 5); $i++) {
            $comment = $this->createComment();
            $comment->setAuthor($user);
            $user->addComment($comment);
        }

        for ($i = 0; $i < $this->faker->numberBetween(0, 5); $i++) {
            $playlist = $this->createUserPlaylist();
            $playlist->setCreator($user);
            $user->addPlaylist($playlist);
        }

        for ($i = 0; $i < $this->faker->numberBetween(0, 5); $i++) {
            $playlistSubscription = $this->createUserPlaylistSubscription();
            $playlistSubscription->setSubscriber($user);
            $user->addPlaylistSubscription($playlistSubscription);
        }

        for ($i = 0; $i < $this->faker->numberBetween(0, 100); $i++) {
            $watchHistory = $this->createUserWatchHistory();
            $watchHistory->setCustomer($user);
            $user->addWatchHistory($watchHistory);
        }

        return $user;
    }

    private $languages = [];
    private function getLanguages(): array
    {
        if (empty($this->languages)) {
            $data = [
                ['label' => 'Français', 'code' => 'FR'],
                ['label' => 'Anglais', 'code' => 'EN'],
                ['label' => 'Espagnol', 'code' => 'ES'],
                ['label' => 'Allemand', 'code' => 'DE'],
                ['label' => 'Italien', 'code' => 'IT'],
                ['label' => 'Portugais', 'code' => 'PT'],
                ['label' => 'Néerlandais', 'code' => 'NL'],
                ['label' => 'Russe', 'code' => 'RU'],
                ['label' => 'Chinois', 'code' => 'ZH'],
                ['label' => 'Japonais', 'code' => 'JA'],
                ['label' => 'Coréen', 'code' => 'KO'],
                ['label' => 'Arabe', 'code' => 'AR'],
                ['label' => 'Hindi', 'code' => 'HI'],
                ['label' => 'Turc', 'code' => 'TR'],
                ['label' => 'Vietnamien', 'code' => 'VI'],
                ['label' => 'Thaï', 'code' => 'TH'],
                ['label' => 'Suédois', 'code' => 'SV'],
                ['label' => 'Danois', 'code' => 'DA'],
                ['label' => 'Finnois', 'code' => 'FI'],
                ['label' => 'Norvégien', 'code' => 'NO'],
                ['label' => 'Polonais', 'code' => 'PL'],
                ['label' => 'Tchèque', 'code' => 'CS'],
                ['label' => 'Slovaque', 'code' => 'SK'],
                ['label' => 'Hongrois', 'code' => 'HU'],
                ['label' => 'Grec', 'code' => 'EL'],
                ['label' => 'Bulgare', 'code' => 'BG'],
                ['label' => 'Roumain', 'code' => 'RO'],
                ['label' => 'Catalan', 'code' => 'CA'],
                ['label' => 'Basque', 'code' => 'EU'],
                ['label' => 'Galicien', 'code' => 'GL'],
            ];

            foreach ($data as $languageData) {
                $languageEntity = new Language();
                $languageEntity->setCode($languageData['label']);
                $languageEntity->setName($languageData['code']);
                $this->languages[] = $languageEntity;
            }

            foreach ($this->languages as $language) {
                $this->dataToPersist[] = $language;
            }
        }

        return $this->languages;
    }

    private function createUserSubscriptionHistory(): array
    {
        $userSubscriptionHistories = [];

        $subscriptions = $this->getSubscriptions();

        $numberOfSubscriptions = $this->faker->numberBetween(1, 3);

        $startDate = $this->faker->dateTimeBetween('-5 year', 'now');
        for ($i = 0; $i < $numberOfSubscriptions; $i++) {
            $userSubscriptionHistory = new SubscriptionHistory();
            $subscription = $subscriptions[$this->faker->numberBetween(0, count($subscriptions) - 1)];
            $userSubscriptionHistory->setSubscription($subscription);
            $userSubscriptionHistory->setStartDate(\DateTimeImmutable::createFromMutable($startDate));
            $endDate = \DateTimeImmutable::createFromMutable($startDate);
            $endDate->modify(sprintf('+%d month', $subscription->getDurationInMonths()));
            $userSubscriptionHistory->setEndDate($endDate);

            $this->dataToPersist[] = $userSubscriptionHistory;

            $userSubscriptionHistories[] = $userSubscriptionHistory;

            $startDate = \DateTime::createFromImmutable($endDate);
        }

        return $userSubscriptionHistories;
    }

    private function createComment(bool $recursive = false ): Comment
    {
        $comment = new Comment(); 
        $comment->setContent($this->faker->sentence(10));
        $comment->setStatus($this->faker->randomElement(CommentsStatusEnum::cases()));
        $comment->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-1 year', 'now')));

        if (!$recursive) {
            for ($i = 0; $i < 3; $i++) {
                $childComment = $this->createComment(true);
                $comment->setChildComment($childComment);
                $childComment->addParentComment($comment);
            }
        }

        $medias = $this->getToPersistMediaData();
        $comment->setMedia($medias[$this->faker->numberBetween(0, count($medias) - 1)]);

        $this->dataToPersist[] = $comment;

        return $comment;
    }

    private function createUserPlaylist(): Playlist
    {
        $playlist = new Playlist();
        $playlist->setName($this->faker->sentence(3));
        $createdAt = $this->faker->dateTimeBetween('-1 year', 'now');
        $playlist->setCreatedAt(\DateTimeImmutable::createFromMutable($createdAt));
        $playlist->setUpdatedAt(\DateTimeImmutable::createFromMutable($createdAt));

        $this->dataToPersist[] = $playlist;

        $medias = $this->getToPersistMediaData();

        for ($i = 0; $i < $this->faker->numberBetween(0, 30); $i++) {
            $media = $medias[$this->faker->numberBetween(0, count($medias) - 1)];
            $playlistMedia = new PlaylistMedia();
            $playlistMedia->setAddedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-1 year', 'now')));
            $playlistMedia->addMedium($media);
            $media->setPlaylistMedia($playlistMedia);

            $this->dataToPersist[] = $playlistMedia;

            $playlist->addPlaylistMedia($playlistMedia);
        }

        return $playlist;
    }

    private function getToPersistPlaylist(): array
    {
        $playlists = [];
        foreach ($this->dataToPersist as $entity) {
            if ($entity instanceof Playlist) {
                $playlists[] = $entity;
            }
        }

        return $playlists;
    }

    private function createUserPlaylistSubscription(): PlaylistSubscription
    {
        $playlistSubscription = new PlaylistSubscription();
        $playlistSubscription->setSubscribedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-1 year', 'now')));

        $this->dataToPersist[] = $playlistSubscription;

        $playlists = $this->getToPersistPlaylist();
        $playlistSubscription->setPlaylist($playlists[$this->faker->numberBetween(0, count($playlists) - 1)]);

        return $playlistSubscription;
    }

    private function createUserWatchHistory(): WatchHistory
    {
        $medias = $this->getToPersistMediaData();

        $watchHistory = new WatchHistory();
        $watchHistory->setLastWatched(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-1 year', 'now')));
        $watchHistory->setNumberOfViews($this->faker->numberBetween(1, 100));

        $this->dataToPersist[] = $watchHistory;

        $media = $medias[$this->faker->numberBetween(0, count($medias) - 1)];
        $watchHistory->addMedium($media);

        return $watchHistory;
    }

    private function getToPersistMediaData(): array
    {
        $medias = [];

        foreach ($this->dataToPersist as $entity) {
            if ($entity instanceof Media) {
                $medias[] = $entity;
            }
        }

        return $medias;
    }

    private function setMediaData(Media $media): void
    {
        $media->setTitle($this->faker->sentence(3));
        $media->setShortDescription($this->faker->sentence(10));
        $media->setLongDescription($this->faker->sentence(40));
        $media->setReleaseDate($this->faker->dateTimeBetween('-40 year', 'now'));
        $media->setCoverImage("https://picsum.photos/1920/1080?random={$this->faker->numberBetween(1, 100)}");
        $media->setMediaType($this->faker->randomElement(MediaTypeEnum::cases()));
        $media->setStaff([
            'Director' => $this->faker->name(),
            'Producer' => $this->faker->name(),
            'Writer' => $this->faker->name(),
            'Music' => $this->faker->name(),
        ]);
        $media->setNominate([
            $this->faker->name(),
            $this->faker->name(),
            $this->faker->name(),
            $this->faker->name(),
            $this->faker->name(),
            $this->faker->name(),
        ]);

        $languages = $this->getLanguages();
        $randomLanguages = $this->faker->randomElements($languages, 3);
        foreach ($randomLanguages as $language) {
            $media->addLanguage($language);
        }
    }

    private function createMovie(): Movie
    {
        $movie = new Movie();
        $this->setMediaData($movie);

        $this->dataToPersist[] = $movie;

        return $movie;
    }

    private function createEpisode(): Episode
    {
        $episode = new Episode();
        $episode->setTitle($this->faker->sentence(3));
        $episode->setDuration(\DateTimeImmutable::createFromFormat('H:i:s', $this->faker->time('H:i:s')));
        $episode->setReleaseDate(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-1 year', 'now')));

        $this->dataToPersist[] = $episode;

        return $episode;
    }

    private function createSeason(int $seasonNumber): Season
    {
        $season = new Season();
        $season->setSeasonNumber($seasonNumber);

        $this->dataToPersist[] = $season;

        for ($i = 0; $i < 10; $i++) {
            $episode = $this->createEpisode();
            $season->addEpisode($episode);
            $episode->setSeason($season);
        }

        return $season;
    }

    private function createSerie(): Serie 
    {
        $serie = new Serie();
        $this->setMediaData($serie);

        $this->dataToPersist[] = $serie;

        for ($i = 0; $i < 5; $i++) {
            $season = $this->createSeason($i + 1);
            $serie->addSeason($season);
            $season->setSerie($serie);
        }

        return $serie;
    }

    private function createCategory(): Category
    {
        $category = new Category();
        $category->setName($this->faker->word());
        $category->setLabel($this->faker->sentence(3));

        $this->dataToPersist[] = $category;

        for ($i = 0; $i < 5; $i++) {
            $movie = $this->createMovie();
            $category->addMedium($movie);
            $movie->addCategory($category);

            $serie = $this->createSerie();
            $category->addMedium($serie);
            $serie->addCategory($category);
        }

        return $category;
    }
}
