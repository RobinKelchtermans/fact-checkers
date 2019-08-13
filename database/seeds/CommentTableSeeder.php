<?php

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::create(
            [
                'article_id' => 'tutorial',
                'user_id' => '1',
                'text' => 'Zeer subjectieve conclusie.',
                'type' => 'inline',
                'associated_text_id' => 'DRTNQzIPPt3z0jUUHmzZ',
            ]
        );
        Comment::create(
            [
                'article_id' => 'tutorial',
                'user_id' => '1',
                'text' => 'Onbetrouwbare bron. Deze website heeft het enkel over vaccinatie. Zeer subjectief.',
                'type' => 'inline',
                'associated_text_id' => 'pL1LefZtOpIKtUU3IJhR',
            ]
        );
        Comment::create(
            [
                'article_id' => 'tutorial',
                'user_id' => '1',
                'text' => 'Wat is de bron van deze "vertrouwelijke stukken"? Werd dit meegegeven aan een betrouwbare journalist?',
                'type' => 'inline',
                'associated_text_id' => 'hmTk6YfBWhHcWbz3nR2W',
            ]
        );
        Comment::create(
            [
                'article_id' => 'tutorial',
                'user_id' => '1',
                'text' => 'Het wordt gesuggereerd, maar is nog nooit bewezen geweest. http://dx.doi.org/10.4061/2011/276393',
                'type' => 'inline',
                'associated_text_id' => 'hVE0EKGOw69KNksSdycW',
            ]
        );
        Comment::create(
            [
                'article_id' => 'tutorial',
                'user_id' => '1',
                'text' => 'Er wordt meermaals verwezen naar andere bronnen. Wat goed kan zijn, maar in dit geval zijn het niet betrouwbare bronnen.',
                'type' => 'normal',
            ]
        );

        for ($i=1; $i <= 5; $i++) { 
            $comment = Comment::find($i);

            $newComment = $comment->replicate();
            $newComment->article_id = 'tutorial-2';
            $newComment->save();
        }
        

        // Comment::create(
        //     [
        //         'article_id' => 'test',
        //         'user_id' => '1',
        //         'text' => 'Dit is een comment',
        //         'type' => 'normal',
        //     ]
        // );
        // Comment::create(
        //     [
        //         'article_id' => 'test',
        //         'user_id' => '1',
        //         'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean consectetur lectus neque, sit amet rhoncus ante pharetra eu. Pellentesque convallis nec libero aliquet commodo. Maecenas eu ornare urna. Quisque et ligula eu risus sollicitudin cursus. Curabitur ut enim ac neque mattis suscipit vitae vitae dui. Donec sit amet justo luctus, maximus risus ut, ullamcorper felis. Sed euismod porta felis, et lacinia turpis sollicitudin et. Morbi vitae mauris venenatis, auctor arcu eget, venenatis lacus. Suspendisse tortor sapien, pellentesque in tellus suscipit, faucibus ullamcorper ex.',
        //         'type' => 'normal',
        //     ]
        // );
        // Comment::create(
        //     [
        //         'article_id' => 'test',
        //         'user_id' => '1',
        //         'text' => 'Dit is een sub comment',
        //         'type' => 'normal',
        //         'parent_id' => '1',
        //     ]
        // );
        
    }
}
