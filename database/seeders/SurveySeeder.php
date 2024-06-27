<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use MattDaneshvar\Survey\Models\Survey;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $survey = Survey::create(['name' => 'Ficha Anamnese']);


        $one = $survey->sections()->create(['name' => 'Secção Um | 1/8']);

        $one->questions()->create([
            'content' => 'O seu médico já lhe disse que tem um problema de saúde e que apenas só deverá fazer exercício físico sob supervisão médica?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $one->questions()->create([
            'content' => 'Sente dor no peito ao realizar exercícios físicos?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $one->questions()->create([
            'content' => 'No último mês, sentiu dor no peito quando não estava a realizar qualquer exercício físico?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $one->questions()->create([
            'content' => 'Já perdeu a consciência em alguma ocasião ou sofreu alguma queda em virtude de tontura?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $one->questions()->create([
            'content' => 'Tem algum problema ósseo ou articular que pode agravar com a prática de exercícios físicos?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $one->questions()->create([
            'content' => 'Algum médico já lhe prescreveu medicamento para a pressão arterial ou para o coração?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $one->questions()->create([
            'content' => 'Tem conhecimento, por informação médica ou pela sua própria experiência, de algum motivo que poderia impedi-lo de praticar exercícios físicos sem supervisão médica?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $one->questions()->create([
            'content' => 'Realizou alguma cirurgia nos últimos 3 meses?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);


        $two = $survey->sections()->create(['name' => 'Secção Dois | 2/8']);

        $two->questions()->create([
            'content' => 'Mesmo sabendo desta situação deseja continuar com o questionário?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);


        $three = $survey->sections()->create(['name' => 'Secção Três | 3/8']);

        $three->questions()->create([
            'content' => 'Qual ou quais são os seus motivos para a prática desta atividade?',
            'type' => 'multiselect',
            'options' => ['Diminuição da % de Gordura', 'Definição Muscular', 'Fortalecimento e reabilitação física', 'Melhoraria da postura corporal', 'Prevenção de doenças', 'Evitar o stress e/ou a ansiedade'],
            'rules' => ['nullable']
        ]);


        $four = $survey->sections()->create(['name' => 'Secção Quatro | 4/8']);

        $four->questions()->create([
            'content' => 'Se é mulher, encontra-se grávida?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $four->questions()->create([
            'content' => 'Em caso afirmativo diga de quanto tempo?',
            'type' => 'text',
        ]);

        $four->questions()->create([
            'content' => 'É fumador(a)?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $four->questions()->create([
            'content' => 'Tem alguma(s) doença(s) endócrina(s), metabólica(s) ou de sangue?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Hemofilia', 'Colesterol Alto', 'Diabetes', 'Problema de Tiroide', 'Bócio', 'Anemia', 'Leucemia', 'Linfoma'],
            'rules' => ['nullable']
        ]);

        $four->questions()->create([
            'content' => 'Tem algum problema ou problemas no aparelho respiratório?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Alergia', 'Asma', 'Apneia do sono', 'Bronquite', 'Tuberculose', 'Cancro do pulmão'],
            'rules' => ['nullable']
        ]);

        $four->questions()->create([
            'content' => 'Tem algum problema ou problemas no aparelho circulatório?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Hipertensão arterial', 'Hipotensão arterial', 'Má circulação', 'Varizes', 'Derrames', 'Trombose', 'AVC', 'Doença cardíaca', 'Enfarte', 'Angina de peito', 'Arritmia'],
            'rules' => ['nullable']
        ]);

        $four->questions()->create([
            'content' => 'Tem algum problema ou problemas no aparelho digestivo?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Gastrite', 'Úlceras', 'Cálculos biliares', 'Refluxo', 'Cancro do estômago', 'Hérnia de hiato', 'Hérnia inguinal', 'Pólipos intestinais', 'Doença de crohn', 'Hemorroidas', 'Cirrose hepática', 'Icterícia', 'Pancreatite', 'Cancro do pâncreas', 'Insuficiência hepática'],
            'rules' => ['nullable']
        ]);

        $four->questions()->create([
            'content' => 'Tem algum problema no aparelho urinário?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Infeções urinárias', 'Insuficiência renal', 'Cálculos renais', 'Cancro da Bexiga'],
            'rules' => ['nullable']
        ]);

        $four->questions()->create([
            'content' => 'Tem algum problema ou problemas na mama ou no aparelho genital?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Quistos mamários', 'Cancro da mama', 'Cancro do útero', 'Cancro de ovários', 'Cancro da próstata', 'Cancro testicular'],
            'rules' => ['nullable']
        ]);

        $four->questions()->create([
            'content' => 'Tem alguma(s) doença(s) Neurológica(s) ou Mental?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Depressão', 'Epilepsia', 'Paralisia', 'Cefaleias', 'Traumatismo craniano', 'Esclerose Lateral Amiotrófica', 'Esclerose Múltipla'],
            'rules' => ['nullable']
        ]);

        $four->questions()->create([
            'content' => 'Tem alguma(s) doença(s) de Pele?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Cancro de Pele', 'Eczema', 'Urticária', 'Psoríase'],
            'rules' => ['nullable']
        ]);

        $four->questions()->create([
            'content' => 'Tem algum problema de Ossos, de Articulações ou de Músculos?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Hérnia discal', 'Cifose', 'Lordose', 'Escoliose', 'Lombalgia', 'Dor ciática', 'Tendinites', 'Entorse', 'Rotura de ligamentos', 'Artrose ou artrite', 'Reumatismo', 'Fibromialgia', 'Osteoporose'],
            'rules' => ['nullable']
        ]);


        $five = $survey->sections()->create(['name' => 'Secção Cinco | 5/8']);

        $five->questions()->create([
            'content' => 'Está a tomar algum medicamento para o problema de saúde que tem atualmente?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $five->questions()->create([
            'content' => 'Liste, por favor os medicamentos que toma.',
            'type' => 'text',
        ]);


        $six = $survey->sections()->create(['name' => 'Secção Seis | 6/8']);

        $six->questions()->create([
            'content' => 'Atualmente tem uma ocupação profissional?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $six->questions()->create([
            'content' => 'Em caso afirmativo, diga qual é?',
            'type' => 'text',
        ]);


        $seven = $survey->sections()->create(['name' => 'Secção Sete | 7/8']);

        $seven->questions()->create([
            'content' => 'A sua ocupação profissional requer longos períodos de movimentos repetitivos',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $seven->questions()->create([
            'content' => 'Em caso afirmativo, explique.',
            'type' => 'text',
        ]);

        $seven->questions()->create([
            'content' => 'Na sua ocupação profissional requer longos períodos sentado?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $seven->questions()->create([
            'content' => 'A sua ocupação profissional exige que use sapatos de saltos altos ou sapatos sociais?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $seven->questions()->create([
            'content' => 'A sua ocupação profissional causa-lhe ansiedade (stress mental)?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $eight = $survey->sections()->create(['name' => 'Secção Oito | 8/8']);

        $eight->questions()->create([
            'content' => '32. Pratica alguma atividade recreativa ou desportiva (golfe, tênis, esqui, etc.)?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $eight->questions()->create([
            'content' => 'Em caso afirmativo, por favor explique.',
            'type' => 'text',
        ]);

        $eight->questions()->create([
            'content' => '33. Tem algum passatempo (ler, fazer jardinagem, trabalhar com carros, etc.)?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $eight->questions()->create([
            'content' => 'Em caso afirmativo, por favor explique.',
            'type' => 'text',
        ]);
    }
}
