<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BMIController extends Controller
{
    public function index(Request $request)
    {
        $bmi = null;
        $category = null;
        $advice = null;
        $color = 'info';
        $alert = 'info';
        
        if ($request->has(['weight', 'height'])) {
            $height = $request->height / 100;
            $bmi = $request->weight / ($height * $height);
            $bmi = round($bmi, 1);
            
            // Déterminer la catégorie et les conseils
            if ($bmi < 18.5) {
                $category = 'Insuffisance pondérale';
                $advice = 'Vous êtes en dessous du poids idéal. Nous vous conseillons de consulter un nutritionniste et d\'adopter un programme de prise de masse musculaire.';
                $color = 'info';
                $alert = 'info';
            } elseif ($bmi < 25) {
                $category = 'Poids normal';
                $advice = 'Félicitations ! Vous avez un poids santé. Continuez à maintenir une activité physique régulière et une alimentation équilibrée.';
                $color = 'success';
                $alert = 'success';
            } elseif ($bmi < 30) {
                $category = 'Surpoids';
                $advice = 'Vous êtes en surpoids. Nous vous recommandons de commencer un programme d\'entraînement cardio et de revoir votre alimentation.';
                $color = 'warning';
                $alert = 'warning';
            } elseif ($bmi < 35) {
                $category = 'Obésité modérée';
                $advice = 'Votre IMC indique une obésité modérée. Une consultation médicale est recommandée. Nos coachs peuvent vous aider avec un programme adapté.';
                $color = 'danger';
                $alert = 'danger';
            } elseif ($bmi < 40) {
                $category = 'Obésité sévère';
                $advice = 'Obésité sévère. Une consultation médicale est fortement recommandée. Nous pouvons vous accompagner avec un programme supervisé.';
                $color = 'danger';
                $alert = 'danger';
            } else {
                $category = 'Obésité morbide';
                $advice = 'Obésité morbide. Veuillez consulter un médecin rapidement. Notre équipe peut vous proposer un programme personnalisé sous supervision médicale.';
                $color = 'danger';
                $alert = 'danger';
            }
        }
        
        return view('bmi', compact('bmi', 'category', 'advice', 'color', 'alert'));
    }
}