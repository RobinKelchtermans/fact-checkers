<?php

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::create(
            [
                'article_id' => 'tutorial',
                'title' => '‘Vertrouwelijk’ document onthult dat 36 kinderen zijn gestorven door vaccin. Hebben we nog meer bewijs nodig dat vaccins schadelijk zijn?',
                'description' => 'Uit vertrouwelijke stukken die aan de pers zijn gelekt, blijkt dat in een periode van twee jaar tijd 36 baby’s zijn gestorven na het vaccin Infanrix Hexa van GlaxoSmithKline.',
                'content' => '<h1>‘Vertrouwelijk’ document onthult dat 36 kinderen zijn gestorven door vaccin. Hebben we nog meer bewijs nodig dat vaccins schadelijk zijn?</h1><img src="/images/tutorial-article.jpg" class="img-fluid"> <p>Uit <span id="hmTk6YfBWhHcWbz3nR2W" class="highlight">vertrouwelijke stukken</span> die aan de pers zijn gelekt, blijkt dat in een periode van twee jaar tijd 36 baby’s zijn gestorven na het vaccin Infanrix Hexa van GlaxoSmithKline.</p><p>Tussen 2009 en 2011 kreeg de farmaceut 1742 meldingen van bijwerkingen na vaccinatie, waaronder 503 ernstige bijwerkingen en 36 sterfgevallen.</p><p>Infanrix Hexa is een vaccin dat is ontwikkeld om zes ziektes te voorkomen: difterie, tetanus, kinkhoest, hepatitis B, polio en Haemophilus influenzae type b (Hib).</p><h5>Slechts een tiende</h5><p>Het vaccin wordt sinds 2011 gebruikt binnen het Rijksvaccinatieprogramma.</p><p>Sinds het in 2000 op de markt is gekomen zijn er 73 baby’s aan gestorven, zo meldde website <em><span id="pL1LefZtOpIKtUU3IJhR" class="highlight">Initiative Citoyenne</span></em>.</p><p>De site merkte verder op dat slechts een tiende van alle bijwerkingen wordt gemeld. In werkelijkheid kan het probleem nog veel groter zijn dan gedacht.</p><h5>Enkele uren</h5><p>Uit de stukken blijkt dat de meeste baby’s enkele dagen na vaccinatie kwamen te overlijden. Drie baby’s stierven binnen enkele uren nadat ze het vaccin hadden gekregen.</p><p>De tragedie komt niet als een verrassing als wordt gekeken naar de ingrediënten die GlaxoSmithKline voor het vaccin gebruikt, schrijft de site <em>GreenMedInfo</em>.</p><h5>Neurotoxine</h5><p>Er zit onder meer een hulpstof in die aluminium bevat. <span class="highlight" id="hVE0EKGOw69KNksSdycW">Aluminium is een neurotoxine die wordt geassocieerd met de ziekte van Alzheimer</span> en beroertes.</p><p><span id="DRTNQzIPPt3z0jUUHmzZ" class="highlight">GlaxoSmithKline mag proberen de feiten te verdoezelen, maar vroeg of laat komt de waarheid boven water.</span></p>',
                'author' => 'Tutorial',
                'published_on' => '2019-03-13 19:53:00',
                'source' => '9 For News',
                'url' => '/images/tutorial-article.jpg',
                'picture_link' => '/images/tutorial-article.jpg',
                'is_tutorial' => true,
            ]
        );

        $tutorial = Article::find('tutorial');

        $newTutorial = $tutorial->replicate();
        $newTutorial->article_id = 'tutorial-1';
        $newTutorial->save();

        $newTutorial = $tutorial->replicate();
        $newTutorial->article_id = 'tutorial-2';
        $newTutorial->save();

        Article::create(
            [
                'article_id' => 'test',
                'title' => 'Klimaatminister Schauvliege: "Makkelijk om drastische maatregelen te nemen, maar iedereen moet meekunnen"',
                'description' => 'Tijdens een lokale CD&V-nieuwjaarsreceptie heeft Vlaams minister van Natuur en Omgeving Joke Schauvliege (CD&V) gereageerd op de tienduizenden klimaatbetogers in Brussel. Ze zei dat het niet moeilijk is om drastische maatregelen te nemen, maar dat dan alleen de rijkere mensen die kunnen betalen.',
                'content' => '<p><b>Tijdens een lokale CD&V-nieuwjaarsreceptie heeft Vlaams minister van Natuur en Omgeving Joke Schauvliege (CD&V) gereageerd op de tienduizenden klimaatbetogers in Brussel. Ze zei dat het niet moeilijk is om drastische maatregelen te nemen, maar dat dan alleen de rijkere mensen die kunnen betalen.</b></p><p>Terwijl 70.000 betogers in Brussel op straat kwamen voor het klimaat, sprak Schauvliege dus op een lokale CD&V-receptie. "Het is heel makkelijk om drastische maatregelen te nemen", zei ze, "maar als niemand mee is en alleen mensen met een dikke portefeuille kunnen dat betalen, is dat geen goed klimaatbeleid."</p><p>Wel herhaalde de minister aan VRT NWS het initiatief van haar voorzitter Wouter Beke om het systeem van de bedrijfswagens te herbekijken. "We willen de bedrijfswagens niet afschaffen, maar als mensen nog zo\'n wagen krijgen, dan zou die niks meer mogen uitstoten. Dat kan heel snel tot een vernieuwing van het wagenpark leiden."</p><p>Tot slot reageerde Schauvliege ook nog op de berichten dat N-VA gelooft dat ons land niet zonder kernenergie kan. "Dat is een afwijking van wat we in december met alle regeringen hebben beslist. Het lijkt me geen goed idee om daarop terug te komen."</p>',
                'author' => 'Kevin Calluy',
                'published_on' => '2019-01-27 19:53:00',
                'source' => 'VRT',
                'url' => 'https://www.vrt.be/vrtnws/nl/2019/01/27/klimaatminister-schauvliege-makkelijk-om-drastische-maatregele/',
                'picture_link' => 'https://www.knack.be/medias/8709/4459127.jpg',
            ]
        );

    }
}
