<?php

namespace Modules\Classroom\Enums\Classroom;

use ArchTech\Enums\Values;
use Filament\Support\Contracts\HasLabel;

enum Cover: string implements HasLabel
{
    use Values;

    case Breakfast = 'breakfast';
    case Honors = 'honors';
    case Graduation = 'graduation';
    case Bookclub = 'bookclub';
    case Code = 'code';
    case Reachout = 'reachout';
    case Learnlanguage = 'learn-language';
    case Backtoschool = 'back-to-school';
    case Read = 'read';
    case WorldStudies = 'world-studies';
    case English = 'english';
    case WorldHistory = 'world-history';
    case SocialStudies = 'social-studies';
    case Geography = 'geography';
    case USHistory = 'us-history';
    case Writing = 'writing';
    case LanguageArts = 'language-arts';
    case Geometry = 'geometry';
    case Psychology = 'psychology';
    case Math = 'math';
    case Chemistry = 'chemistry';
    case Physics = 'physics';
    case Biology = 'biology';
    case Coffee = 'coffee';
    case Cinema = 'cinema';
    case Violin2 = 'violin2';
    case Arts = 'arts';
    case Theatreopera = 'theatre-opera';
    case Mealfamily = 'meal-family';
    case Birthday = 'birthday';
    case Learninstrument = 'learn-instrument';
    case Design = 'design';
    case Concert = 'concert';
    case Dancing = 'dancing';
    case Cooking = 'cooking';
    case Bbq = 'bbq';
    case Wrestling = 'wrestling';
    case Volleyball = 'volleyball';
    case Athleticsjumping = 'athletics-jumping';
    case Americanfootball = 'american-football';
    case Triathlon = 'triathlon';
    case Rowing = 'rowing';
    case Equestrian = 'equestrian';
    case Waterpolo = 'waterpolo';
    case Golf = 'golf';
    case Kayaking = 'kayaking';
    case Bowling = 'bowling';
    case Cycling = 'cycling';
    case Soccer = 'soccer';
    case Karate = 'karate';
    case Billiard = 'billiard';
    case Cricket = 'cricket';
    case Tennis = 'tennis';
    case Swimming = 'swimming';
    case Climbing = 'climbing';
    case Cyclingbmx = 'cycling-bmx';
    case Gym = 'gym';
    case Pingpong = 'ping-pong';
    case Fencing = 'fencing';
    case Boxing = 'boxing';
    case Economics = 'economics';
    case Walkingdog = 'walking-dog';
    case Hobby = 'hobby';
    case Sailing = 'sailing';
    case Videogaming = 'videogaming';
    case Carmaintenance = 'car-maintenance';
    case Repair = 'repair';
    case Hiking = 'hiking';
    case Haircut = 'haircut';
    case Gamenight = 'game-night';
    case Camping = 'camping';
    case Oilchange = 'oil-change';
    case Handcraft = 'handcraft';

    public function getOriginalUrl(): string
    {
        return match ($this) {
            self::Breakfast => 'https://gstatic.com/classroom/themes/img_breakfast.jpg',
            self::Honors => 'https://gstatic.com/classroom/themes/Honors.jpg',
            self::Graduation => 'https://gstatic.com/classroom/themes/img_graduation.jpg',
            self::Bookclub => 'https://gstatic.com/classroom/themes/img_bookclub.jpg',
            self::Code => 'https://gstatic.com/classroom/themes/img_code.jpg',
            self::Reachout => 'https://gstatic.com/classroom/themes/img_reachout.jpg',
            self::Learnlanguage => 'https://gstatic.com/classroom/themes/img_learnlanguage.jpg',
            self::Backtoschool => 'https://gstatic.com/classroom/themes/img_backtoschool.jpg',
            self::Read => 'https://gstatic.com/classroom/themes/img_read.jpg',
            self::WorldStudies => 'https://gstatic.com/classroom/themes/WorldStudies.jpg',
            self::English => 'https://gstatic.com/classroom/themes/English.jpg',
            self::WorldHistory => 'https://gstatic.com/classroom/themes/WorldHistory.jpg',
            self::SocialStudies => 'https://gstatic.com/classroom/themes/SocialStudies.jpg',
            self::Geography => 'https://gstatic.com/classroom/themes/Geography.jpg',
            self::USHistory => 'https://gstatic.com/classroom/themes/USHistory.jpg',
            self::Writing => 'https://gstatic.com/classroom/themes/Writing.jpg',
            self::LanguageArts => 'https://gstatic.com/classroom/themes/LanguageArts.jpg',
            self::Geometry => 'https://gstatic.com/classroom/themes/Geometry.jpg',
            self::Psychology => 'https://gstatic.com/classroom/themes/Psychology.jpg',
            self::Math => 'https://gstatic.com/classroom/themes/Math.jpg',
            self::Chemistry => 'https://gstatic.com/classroom/themes/Chemistry.jpg',
            self::Physics => 'https://gstatic.com/classroom/themes/Physics.jpg',
            self::Biology => 'https://gstatic.com/classroom/themes/Biology.jpg',
            self::Coffee => 'https://gstatic.com/classroom/themes/img_coffee.jpg',
            self::Cinema => 'https://gstatic.com/classroom/themes/img_cinema.jpg',
            self::Violin2 => 'https://gstatic.com/classroom/themes/img_violin2.jpg',
            self::Arts => 'https://gstatic.com/classroom/themes/img_arts.jpg',
            self::Theatreopera => 'https://gstatic.com/classroom/themes/img_theatreopera.jpg',
            self::Mealfamily => 'https://gstatic.com/classroom/themes/img_mealfamily.jpg',
            self::Birthday => 'https://gstatic.com/classroom/themes/img_birthday.jpg',
            self::Learninstrument => 'https://gstatic.com/classroom/themes/img_learninstrument.jpg',
            self::Design => 'https://gstatic.com/classroom/themes/Design.jpg',
            self::Concert => 'https://gstatic.com/classroom/themes/img_concert.jpg',
            self::Dancing => 'https://gstatic.com/classroom/themes/img_dancing.jpg',
            self::Cooking => 'https://gstatic.com/classroom/themes/img_cooking.jpg',
            self::Bbq => 'https://gstatic.com/classroom/themes/img_bbq.jpg',
            self::Wrestling => 'https://gstatic.com/classroom/themes/img_wrestling.jpg',
            self::Volleyball => 'https://gstatic.com/classroom/themes/img_volleyball.jpg',
            self::Athleticsjumping => 'https://gstatic.com/classroom/themes/img_athleticsjumping.jpg',
            self::Americanfootball => 'https://gstatic.com/classroom/themes/img_americanfootball.jpg',
            self::Triathlon => 'https://gstatic.com/classroom/themes/img_triathlon.jpg',
            self::Rowing => 'https://gstatic.com/classroom/themes/img_rowing.jpg',
            self::Equestrian => 'https://gstatic.com/classroom/themes/img_equestrian.jpg',
            self::Waterpolo => 'https://gstatic.com/classroom/themes/img_waterpolo.jpg',
            self::Golf => 'https://gstatic.com/classroom/themes/img_golf.jpg',
            self::Kayaking => 'https://gstatic.com/classroom/themes/img_kayaking.jpg',
            self::Bowling => 'https://gstatic.com/classroom/themes/img_bowling.jpg',
            self::Cycling => 'https://gstatic.com/classroom/themes/img_cycling.jpg',
            self::Soccer => 'https://gstatic.com/classroom/themes/img_soccer.jpg',
            self::Karate => 'https://gstatic.com/classroom/themes/img_karate.jpg',
            self::Billiard => 'https://gstatic.com/classroom/themes/img_billiard.jpg',
            self::Cricket => 'https://gstatic.com/classroom/themes/img_cricket.jpg',
            self::Tennis => 'https://gstatic.com/classroom/themes/img_tennis.jpg',
            self::Swimming => 'https://gstatic.com/classroom/themes/img_swimming.jpg',
            self::Climbing => 'https://gstatic.com/classroom/themes/img_climbing.jpg',
            self::Cyclingbmx => 'https://gstatic.com/classroom/themes/img_cyclingbmx.jpg',
            self::Gym => 'https://gstatic.com/classroom/themes/img_gym.jpg',
            self::Pingpong => 'https://gstatic.com/classroom/themes/img_pingpong.jpg',
            self::Fencing => 'https://gstatic.com/classroom/themes/img_fencing.jpg',
            self::Boxing => 'https://gstatic.com/classroom/themes/img_boxing.jpg',
            self::Economics => 'https://gstatic.com/classroom/themes/Economics.jpg',
            self::Walkingdog => 'https://gstatic.com/classroom/themes/img_walkingdog.jpg',
            self::Hobby => 'https://gstatic.com/classroom/themes/img_hobby.jpg',
            self::Sailing => 'https://gstatic.com/classroom/themes/img_sailing.jpg',
            self::Videogaming => 'https://gstatic.com/classroom/themes/img_videogaming.jpg',
            self::Carmaintenance => 'https://gstatic.com/classroom/themes/img_carmaintenance.jpg',
            self::Repair => 'https://gstatic.com/classroom/themes/img_repair.jpg',
            self::Hiking => 'https://gstatic.com/classroom/themes/img_hiking.jpg',
            self::Haircut => 'https://gstatic.com/classroom/themes/img_haircut.jpg',
            self::Gamenight => 'https://gstatic.com/classroom/themes/img_gamenight.jpg',
            self::Camping => 'https://gstatic.com/classroom/themes/img_camping.jpg',
            self::Oilchange => 'https://gstatic.com/classroom/themes/img_oilchange.jpg',
            self::Handcraft => 'https://gstatic.com/classroom/themes/img_handcraft.jpg',
        };
    }

    public function getThumbnailUrl(): string
    {
        return match ($this) {
            self::Breakfast => 'https://gstatic.com/classroom/themes/img_breakfast_thumb.jpg',
            self::Honors => 'https://gstatic.com/classroom/themes/Honors_thumb.jpg',
            self::Graduation => 'https://gstatic.com/classroom/themes/img_graduation_thumb.jpg',
            self::Bookclub => 'https://gstatic.com/classroom/themes/img_bookclub_thumb.jpg',
            self::Code => 'https://gstatic.com/classroom/themes/img_code_thumb.jpg',
            self::Reachout => 'https://gstatic.com/classroom/themes/img_reachout_thumb.jpg',
            self::Learnlanguage => 'https://gstatic.com/classroom/themes/img_learnlanguage_thumb.jpg',
            self::Backtoschool => 'https://gstatic.com/classroom/themes/img_backtoschool_thumb.jpg',
            self::Read => 'https://gstatic.com/classroom/themes/img_read_thumb.jpg',
            self::WorldStudies => 'https://gstatic.com/classroom/themes/WorldStudies_thumb.jpg',
            self::English => 'https://gstatic.com/classroom/themes/English_thumb.jpg',
            self::WorldHistory => 'https://gstatic.com/classroom/themes/WorldHistory_thumb.jpg',
            self::SocialStudies => 'https://gstatic.com/classroom/themes/SocialStudies_thumb.jpg',
            self::Geography => 'https://gstatic.com/classroom/themes/Geography_thumb.jpg',
            self::USHistory => 'https://gstatic.com/classroom/themes/USHistory_thumb.jpg',
            self::Writing => 'https://gstatic.com/classroom/themes/Writing_thumb.jpg',
            self::LanguageArts => 'https://gstatic.com/classroom/themes/LanguageArts_thumb.jpg',
            self::Geometry => 'https://gstatic.com/classroom/themes/Geometry_thumb.jpg',
            self::Psychology => 'https://gstatic.com/classroom/themes/Psychology_thumb.jpg',
            self::Math => 'https://gstatic.com/classroom/themes/Math_thumb.jpg',
            self::Chemistry => 'https://gstatic.com/classroom/themes/Chemistry_thumb.jpg',
            self::Physics => 'https://gstatic.com/classroom/themes/Physics_thumb.jpg',
            self::Biology => 'https://gstatic.com/classroom/themes/Biology_thumb.jpg',
            self::Coffee => 'https://gstatic.com/classroom/themes/img_coffee_thumb.jpg',
            self::Cinema => 'https://gstatic.com/classroom/themes/img_cinema_thumb.jpg',
            self::Violin2 => 'https://gstatic.com/classroom/themes/img_violin2_thumb.jpg',
            self::Arts => 'https://gstatic.com/classroom/themes/img_arts_thumb.jpg',
            self::Theatreopera => 'https://gstatic.com/classroom/themes/img_theatreopera_thumb.jpg',
            self::Mealfamily => 'https://gstatic.com/classroom/themes/img_mealfamily_thumb.jpg',
            self::Birthday => 'https://gstatic.com/classroom/themes/img_birthday_thumb.jpg',
            self::Learninstrument => 'https://gstatic.com/classroom/themes/img_learninstrument_thumb.jpg',
            self::Design => 'https://gstatic.com/classroom/themes/Design_thumb.jpg',
            self::Concert => 'https://gstatic.com/classroom/themes/img_concert_thumb.jpg',
            self::Dancing => 'https://gstatic.com/classroom/themes/img_dancing_thumb.jpg',
            self::Cooking => 'https://gstatic.com/classroom/themes/img_cooking_thumb.jpg',
            self::Bbq => 'https://gstatic.com/classroom/themes/img_bbq_thumb.jpg',
            self::Wrestling => 'https://gstatic.com/classroom/themes/img_wrestling_thumb.jpg',
            self::Volleyball => 'https://gstatic.com/classroom/themes/img_volleyball_thumb.jpg',
            self::Athleticsjumping => 'https://gstatic.com/classroom/themes/img_athleticsjumping_thumb.jpg',
            self::Americanfootball => 'https://gstatic.com/classroom/themes/img_americanfootball_thumb.jpg',
            self::Triathlon => 'https://gstatic.com/classroom/themes/img_triathlon_thumb.jpg',
            self::Rowing => 'https://gstatic.com/classroom/themes/img_rowing_thumb.jpg',
            self::Equestrian => 'https://gstatic.com/classroom/themes/img_equestrian_thumb.jpg',
            self::Waterpolo => 'https://gstatic.com/classroom/themes/img_waterpolo_thumb.jpg',
            self::Golf => 'https://gstatic.com/classroom/themes/img_golf_thumb.jpg',
            self::Kayaking => 'https://gstatic.com/classroom/themes/img_kayaking_thumb.jpg',
            self::Bowling => 'https://gstatic.com/classroom/themes/img_bowling_thumb.jpg',
            self::Cycling => 'https://gstatic.com/classroom/themes/img_cycling_thumb.jpg',
            self::Soccer => 'https://gstatic.com/classroom/themes/img_soccer_thumb.jpg',
            self::Karate => 'https://gstatic.com/classroom/themes/img_karate_thumb.jpg',
            self::Billiard => 'https://gstatic.com/classroom/themes/img_billiard_thumb.jpg',
            self::Cricket => 'https://gstatic.com/classroom/themes/img_cricket_thumb.jpg',
            self::Tennis => 'https://gstatic.com/classroom/themes/img_tennis_thumb.jpg',
            self::Swimming => 'https://gstatic.com/classroom/themes/img_swimming_thumb.jpg',
            self::Climbing => 'https://gstatic.com/classroom/themes/img_climbing_thumb.jpg',
            self::Cyclingbmx => 'https://gstatic.com/classroom/themes/img_cyclingbmx_thumb.jpg',
            self::Gym => 'https://gstatic.com/classroom/themes/img_gym_thumb.jpg',
            self::Pingpong => 'https://gstatic.com/classroom/themes/img_pingpong_thumb.jpg',
            self::Fencing => 'https://gstatic.com/classroom/themes/img_fencing_thumb.jpg',
            self::Boxing => 'https://gstatic.com/classroom/themes/img_boxing_thumb.jpg',
            self::Economics => 'https://gstatic.com/classroom/themes/Economics_thumb.jpg',
            self::Walkingdog => 'https://gstatic.com/classroom/themes/img_walkingdog_thumb.jpg',
            self::Hobby => 'https://gstatic.com/classroom/themes/img_hobby_thumb.jpg',
            self::Sailing => 'https://gstatic.com/classroom/themes/img_sailing_thumb.jpg',
            self::Videogaming => 'https://gstatic.com/classroom/themes/img_videogaming_thumb.jpg',
            self::Carmaintenance => 'https://gstatic.com/classroom/themes/img_carmaintenance_thumb.jpg',
            self::Repair => 'https://gstatic.com/classroom/themes/img_repair_thumb.jpg',
            self::Hiking => 'https://gstatic.com/classroom/themes/img_hiking_thumb.jpg',
            self::Haircut => 'https://gstatic.com/classroom/themes/img_haircut_thumb.jpg',
            self::Gamenight => 'https://gstatic.com/classroom/themes/img_gamenight_thumb.jpg',
            self::Camping => 'https://gstatic.com/classroom/themes/img_camping_thumb.jpg',
            self::Oilchange => 'https://gstatic.com/classroom/themes/img_oilchange_thumb.jpg',
            self::Handcraft => 'https://gstatic.com/classroom/themes/img_handcraft_thumb.jpg',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Breakfast => 'Breakfast',
            self::Honors => 'Honors',
            self::Graduation => 'Graduation',
            self::Bookclub => 'Bookclub',
            self::Code => 'Code',
            self::Reachout => 'Reachout',
            self::Learnlanguage => 'Learn Language',
            self::Backtoschool => 'Back to School',
            self::Read => 'Read',
            self::WorldStudies => 'World Studies',
            self::English => 'English',
            self::WorldHistory => 'World History',
            self::SocialStudies => 'Social Studies',
            self::Geography => 'Geography',
            self::USHistory => 'US History',
            self::Writing => 'Writing',
            self::LanguageArts => 'Language Arts',
            self::Geometry => 'Geometry',
            self::Psychology => 'Psychology',
            self::Math => 'Math',
            self::Chemistry => 'Chemistry',
            self::Physics => 'Physics',
            self::Biology => 'Biology',
            self::Coffee => 'Coffee',
            self::Cinema => 'Cinema',
            self::Violin2 => 'Violin 2',
            self::Arts => 'Arts',
            self::Theatreopera => 'Theatre Opera',
            self::Mealfamily => 'Meal Family',
            self::Birthday => 'Birthday',
            self::Learninstrument => 'Learn Instrument',
            self::Design => 'Design',
            self::Concert => 'Concert',
            self::Dancing => 'Dancing',
            self::Cooking => 'Cooking',
            self::Bbq => 'BBQ',
            self::Wrestling => 'Wrestling',
            self::Volleyball => 'Volleyball',
            self::Athleticsjumping => 'Athletics Jumping',
            self::Americanfootball => 'American Football',
            self::Triathlon => 'Triathlon',
            self::Rowing => 'Rowing',
            self::Equestrian => 'Equestrian',
            self::Waterpolo => 'Waterpolo',
            self::Golf => 'Golf',
            self::Kayaking => 'Kayaking',
            self::Bowling => 'Bowling',
            self::Cycling => 'Cycling',
            self::Soccer => 'Soccer',
            self::Karate => 'Karate',
            self::Billiard => 'Billiard',
            self::Cricket => 'Cricket',
            self::Tennis => 'Tennis',
            self::Swimming => 'Swimming',
            self::Climbing => 'Climbing',
            self::Cyclingbmx => 'Cycling BMX',
            self::Gym => 'Gym',
            self::Pingpong => 'Ping Pong',
            self::Fencing => 'Fencing',
            self::Boxing => 'Boxing',
            self::Economics => 'Economics',
            self::Walkingdog => 'Walking Dog',
            self::Hobby => 'Hobby',
            self::Sailing => 'Sailing',
            self::Videogaming => 'Video Gaming',
            self::Carmaintenance => 'Car Maintenance',
            self::Repair => 'Repair',
            self::Hiking => 'Hiking',
            self::Haircut => 'Haircut',
            self::Gamenight => 'Game Night',
            self::Camping => 'Camping',
            self::Oilchange => 'Oil Change',
            self::Handcraft => 'Handcraft',
        };
    }

    public function getOriginalPath(): string
    {
        return url('images/covers/' . basename(parse_url($this->getOriginalUrl(), PHP_URL_PATH)));
    }

    public function getThumbnailPath(): string
    {
        return url('images/covers/' . basename(parse_url($this->getThumbnailUrl(), PHP_URL_PATH)));
    }
}
