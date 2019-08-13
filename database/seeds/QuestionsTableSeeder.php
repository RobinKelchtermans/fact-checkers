<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
            // Philanthropist
            [
                'userType' => "Philanthropist",
                'reference' => "P1",
                'question' => "Het maakt me blij als ik anderen kan helpen.",
                'correlation' => 0.780,
            ],
            [
                'userType' => "Philanthropist",
                'reference' => "P2",
                'question' => "Ik vind het leuk om anderen te helpen zich te oriënteren in nieuwe situaties.",
                'correlation' => 0.775,
            ],
            [
                'userType' => "Philanthropist",
                'reference' => "P3",
                'question' => "Ik deel graag mijn kennis.",
                'correlation' => 0.783,
            ],
            [
                'userType' => "Philanthropist",
                'reference' => "P4",
                'question' => "Het welzijn van anderen is belangrijk voor mij.",
                'correlation' => 0.763,
            ],
            // Socialiser
            [
                'userType' => "Socialiser",
                'reference' => "S1",
                'question' => "Het is belangrijk voor mij om met anderen om te gaan.",
                'correlation' => 0.734,
            ],
            [
                'userType' => "Socialiser",
                'reference' => "S2",
                'question' => "Ik vind het leuk deel uit te maken van een team.",
                'correlation' => 0.617,
            ],
            [
                'userType' => "Socialiser",
                'reference' => "S3",
                'question' => "Het is belangrijk voor mij om het gevoel te hebben dat ik deel uitmaak van een gemeenschap.",
                'correlation' => 0.676,
            ],
            [
                'userType' => "Socialiser",
                'reference' => "S4",
                'question' => "Ik geniet van groepsactiviteiten.",
                'correlation' => 0.662,
            ],
            // Free Spirit
            [
                'userType' => "Free Spirit",
                'reference' => "F1",
                'question' => "Het is belangrijk voor mij om mijn eigen weg te volgen.",
                'correlation' => 0.480,
            ],
            [
                'userType' => "Free Spirit",
                'reference' => "F2",
                'question' => "Ik laat me vaak leiden door mijn nieuwsgierigheid.",
                'correlation' => 0.546,
            ],
            [
                'userType' => "Free Spirit",
                'reference' => "F3",
                'question' => "Ik hou van nieuwe dingen te proberen.",
                'correlation' => 0.525,
            ],
            [
                'userType' => "Free Spirit",
                'reference' => "F4",
                'question' => "Zelfstandig zijn is belangrijk voor mij.",
                'correlation' => 0.496,
            ],
            // Achiever
            [
                'userType' => "Achiever",
                'reference' => "A1",
                'question' => "Ik hou ervan om obstakels te verslaan.",
                'correlation' => 0.574,
            ],
            [
                'userType' => "Achiever",
                'reference' => "A2",
                'question' => "Het is belangrijk voor mij om mijn taken altijd volledig uit te voeren.",
                'correlation' => 0.485,
            ],
            [
                'userType' => "Achiever",
                'reference' => "A3",
                'question' => "Het is moeilijk voor mij om een probleem los te laten voordat ik een oplossing heb gevonden.",
                'correlation' => 0.569,
            ],
            [
                'userType' => "Achiever",
                'reference' => "A4",
                'question' => "Ik hou van het beheersen van moeilijke taken.",
                'correlation' => 0.604,
            ],
            // Disruptor
            [
                'userType' => "Disruptor",
                'reference' => "D1",
                'question' => "Ik provoceer graag.",
                'correlation' => 0.588,
            ],
            [
                'userType' => "Disruptor",
                'reference' => "D2",
                'question' => "Ik stel de status-quo in vraag.",
                'correlation' => 0.398,
            ],
            [
                'userType' => "Disruptor",
                'reference' => "D3",
                'question' => "Ik zie mezelf als een rebel.",
                'correlation' => 0.569,
            ],
            [
                'userType' => "Disruptor",
                'reference' => "D4",
                'question' => "Ik hou niet van het volgen van regels.",
                'correlation' => 0.577,
            ],
            // Player
            [
                'userType' => "Player",
                'reference' => "P1",
                'question' => "Ik hou van wedstrijden waarbij een prijs kan worden gewonnen.",
                'correlation' => 0.459,
            ],
            [
                'userType' => "Player",
                'reference' => "P2",
                'question' => "Beloningen zijn een geweldige manier om me te motiveren.",
                'correlation' => 0.622,
            ],
            [
                'userType' => "Player",
                'reference' => "P3",
                'question' => "Rendement van de investering is belangrijk voor mij.",
                'correlation' => 0.313,
            ],
            [
                'userType' => "Player",
                'reference' => "P4",
                'question' => "Als de beloning voldoende is, zal ik me inspannen.",
                'correlation' => 0.568,
            ],
        ]);
    }
}
