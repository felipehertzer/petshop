<?php


use App\Category;
use App\Pet;
use App\Photo;
use App\Tag;
use Illuminate\Database\Seeder;

class PetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //clear table
        Pet::truncate();

        $cat1 = Category::create([
            'name' => 'cat 1',
        ]);

        $cat2 = Category::create([
            'name' => 'cat 2',
        ]);

        $cat3 = Category::create([
            'name' => 'cat 3',
        ]);

        $pet1 = Pet::create([
            'name' => 'dog 1',
            'categoryId' => $cat1->id,
            'status' => 'available',
        ]);

        Tag::create([
            'name' => 'tag1',
            'petId' => $pet1->id,
        ]);

        Tag::create([
            'name' => 'tag2',
            'petId' => $pet1->id,
        ]);

        Photo::create([
            'petId' => $pet1->id,
            'additionalMetadata' => '',
            'photoUrl' => 'https://www.cesarsway.com/wp-content/uploads/2019/10/AdobeStock_190562703-1024x713.jpeg',
        ]);

        Photo::create([
            'petId' => $pet1->id,
            'additionalMetadata' => '',
            'photoUrl' => 'https://www.washingtonpost.com/wp-apps/imrs.php?src=https://arc-anglerfish-washpost-prod-washpost.s3.amazonaws.com/public/HB4AT3D3IMI6TMPTWIZ74WAR54.jpg&w=1440',
        ]);

        $pet2 = Pet::create([
            'name' => 'dog 2',
            'categoryId' => $cat2->id,
            'status' => 'available',
        ]);

        Tag::create([
            'name' => 'tag6',
            'petId' => $pet2->id,
        ]);

        Tag::create([
            'name' => 'tag9',
            'petId' => $pet2->id,
        ]);

        Photo::create([
            'petId' => $pet2->id,
            'additionalMetadata' => '',
            'photoUrl' => 'https://www.cesarsway.com/wp-content/uploads/2019/10/AdobeStock_190562703-1024x713.jpeg',
        ]);

        Photo::create([
            'petId' => $pet2->id,
            'additionalMetadata' => '',
            'photoUrl' => 'https://www.washingtonpost.com/wp-apps/imrs.php?src=https://arc-anglerfish-washpost-prod-washpost.s3.amazonaws.com/public/HB4AT3D3IMI6TMPTWIZ74WAR54.jpg&w=1440',
        ]);

        $pet3 = Pet::create([
            'name' => 'dog 3',
            'categoryId' => $cat3->id,
            'status' => 'pending',
        ]);

        Tag::create([
            'name' => 'tag1',
            'petId' => $pet3->id,
        ]);

        Tag::create([
            'name' => 'tag2',
            'petId' => $pet3->id,
        ]);

        Photo::create([
            'petId' => $pet3->id,
            'additionalMetadata' => '',
            'photoUrl' => 'https://www.cesarsway.com/wp-content/uploads/2019/10/AdobeStock_190562703-1024x713.jpeg',
        ]);

        Photo::create([
            'petId' => $pet3->id,
            'additionalMetadata' => '',
            'photoUrl' => 'https://www.washingtonpost.com/wp-apps/imrs.php?src=https://arc-anglerfish-washpost-prod-washpost.s3.amazonaws.com/public/HB4AT3D3IMI6TMPTWIZ74WAR54.jpg&w=1440',
        ]);

        $pet4 = Pet::create([
            'name' => 'dog 4',
            'categoryId' => $cat1->id,
            'status' => 'sold',
        ]);

        Tag::create([
            'name' => 'tag4',
            'petId' => $pet4->id,
        ]);

        Tag::create([
            'name' => 'tag8',
            'petId' => $pet4->id,
        ]);

        Photo::create([
            'petId' => $pet4->id,
            'additionalMetadata' => '',
            'photoUrl' => 'https://www.cesarsway.com/wp-content/uploads/2019/10/AdobeStock_190562703-1024x713.jpeg',
        ]);

        Photo::create([
            'petId' => $pet4->id,
            'additionalMetadata' => '',
            'photoUrl' => 'https://www.washingtonpost.com/wp-apps/imrs.php?src=https://arc-anglerfish-washpost-prod-washpost.s3.amazonaws.com/public/HB4AT3D3IMI6TMPTWIZ74WAR54.jpg&w=1440',
        ]);

        $pet5 = Pet::create([
            'name' => 'dog 5',
            'categoryId' => $cat1->id,
            'status' => 'sold',
        ]);

        Tag::create([
            'name' => 'tag3',
            'petId' => $pet5->id,
        ]);

        Tag::create([
            'name' => 'tag4',
            'petId' => $pet5->id,
        ]);

        Photo::create([
            'petId' => $pet5->id,
            'additionalMetadata' => '',
            'photoUrl' => 'https://www.cesarsway.com/wp-content/uploads/2019/10/AdobeStock_190562703-1024x713.jpeg',
        ]);

        Photo::create([
            'petId' => $pet5->id,
            'additionalMetadata' => '',
            'photoUrl' => 'https://www.washingtonpost.com/wp-apps/imrs.php?src=https://arc-anglerfish-washpost-prod-washpost.s3.amazonaws.com/public/HB4AT3D3IMI6TMPTWIZ74WAR54.jpg&w=1440',
        ]);

    }
}
