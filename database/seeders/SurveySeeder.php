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

        $survey->questions()->create([
            'content' => '1. Tem conhecimento, por informação médica ou pela sua própria experiência, de algum motivo que poderia impedi-lo de praticar exercícios físicos sem supervisão médica?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '2. Sente dor no peito ao realizar exercícios físicos?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '3. No último mês, sentiu dor no peito quando não estava a realizar qualquer exercício físico?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '4. Já perdeu a consciência em alguma ocasião ou sofreu alguma queda em virtude de tontura?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '5. Tem algum problema ósseo ou articular que pode agravar com a prática de exercícios físicos?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '6. Algum médico já lhe prescreveu medicamento para a pressão arterial ou para o coração?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '7. O seu médico já lhe disse que tem um problema de saúde e que apenas só deverá fazer exercício físico sob supervisão médica?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '8. Qual ou quais são os seus motivos para a prática desta atividade?',
            'type' => 'multiselect',
            'options' => ['Diminuição da % de Gordura', 'Definição Muscular', 'Fortalecimento e reabilitação física', 'Melhoraria da postura corporal', 'Prevenção de doenças', 'Evitar o stress e/ou a ansiedade']
        ]);

        $survey->questions()->create([
            'content' => '10. Pretende PT ELETROESTIMULAÇÃO? (Treino individualizado, de 30 min. de duração em alta intensidade e acompanhado por um profissional do exercício físico que elabora uma planificação cuidada atendendo às características, necessidades e objetivos específicos do cliente, com a utilização de um fato que transmite impulsos elétricos que estimulam 350 músculos em simultâneo, enquanto realiza os exercícios físicos programados)',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '11. Pretende PT TREINO FUNCIONAL? (Treino individualizado, de 30 min. de duração em alta intensidade e acompanhado por um profissional do exercício físico que elabora uma planificação cuidada atendendo às características, necessidades e objetivos específicos do cliente, com a utilização de materiais específicos e variados que permitem a realização de exercícios que simulam movimentos do dia-a-dia)',
            'type' => 'multiselect',
            'options' => ['PERSONAL TRAINING  (treino individualizado ou de 2/3 clientes em simultâneo acompanhado por um profissional do exercício físico que elabora uma planificação cuidada atendendo às características, necessidades e objetivos específicos de cada cliente, com uma duração de 60 min. por sessão)',
                'PT EQUI. PILATES (Treino personalizado de 60 min., acompanhado por um profissional de exercício físico, que elabora um plano ajustado ás necessidades do cliente com uso de aparelhos de molas que auxiliam na realização dos movimentos)',
                'TREINO FUNCIONAL (Treino em grupo de 60min. acompanhado por um profissional de exercício físico, que elabora um plano constituído por um conjunto de exercícios dinâmicos e cadenciados que procuram os movimentos naturais do ser humano ajustados às funções e tarefas diárias do cliente, trabalhando os músculos de uma forma global e diversificada, através da utilização um diverso número de acessórios como elásticos, bolas, cordas, kettlebells, halteres, barras, ou Racks, etc.)',
                'TREINO LIVRE (Treino funcional de 60 min. sem acompanhamento profissional mas supervisionado por um profissional de exercício físico presente no espaço, onde dentro da disponibilidade material e espacial, o cliente elabora o seu próprio plano de treino)'
            ]
        ]);

        $survey->questions()->create([
            'content' => '12. Tem alguma(s) das situações de saúde mencionadas de seguida? Gravidez; Cancro; Tuberculose; AVC; Doença cardíaca; Enfarte; Angina de peito; Cirrose hepática; Insuficiência hepática; Pancreatite; Icterícia; Insuficiência renal; Cálculos renais; Quistos mamários; Epilepsia; Psoríase',
            'type' => 'multiselect',
            'options' => ['Gravidez', 'Cancro', 'Tuberculose', 'AVC', 'Doença cardíaca', 'Enfarte', 'Angina de peito', 'Cirrose hepática', 'Insuficiência hepática', 'Pancreatite', 'Icterícia', 'Insuficiência renal', 'Cálculos renais', 'Quistos mamários', 'Epilepsia', 'Psoríase']
        ]);

        $survey->questions()->create([
            'content' => '13. Tem alguma(s) das situações de saúde mencionadas de seguida? Gravidez; Cancro; Tuberculose; AVC; Doença cardíaca; Enfarte; Angina de peito; Cirrose hepática; Insuficiência hepática; Pancreatite; Icterícia; Insuficiência renal; Cálculos renais; Quistos mamários; Epilepsia; Psoríase',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '14. Uma vez que o seu estado de saúde impossibilita de poder frequentar a modalidade de PT de Eletroestimulação, pretende frequentar outro serviço?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '15. Se é mulher, encontra-se grávida?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '16. É fumador(a)?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '17. Tem alguma(s) doença(s) endócrina(s), metabólica(s) ou de sangue?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Hemofilia', 'Colesterol Alto', 'Diabetes', 'Problema de Tiroide', 'Bócio', 'Anemia', 'Leucemia', 'Linfoma']
        ]);

        $survey->questions()->create([
            'content' => '18. Tem alguma(s) doença(s) endócrina(s), metabólica(s) ou de sangue?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Alergia', 'Asma', 'Apneia do sono', 'Bronquite', 'Tuberculose', 'Cancro do pulmão']
        ]);

        $survey->questions()->create([
            'content' => '19. Tem algum problema ou problemas no coração ou aparelho circulatório?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Hipertensão arterial', 'Hipotensão arterial', 'Má circulação', 'Varizes', 'Derrames', 'Trombose', 'AVC', 'Doença cardíaca', 'Enfarte', 'Angina de peito', 'Arritmia']
        ]);

        $survey->questions()->create([
            'content' => '20. Tem algum problema ou problemas no aparelho digestivo?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Gastrite', 'Úlceras', 'Cálculos biliares', 'Refluxo', 'Cancro do estômago', 'Hérnia de hiato', 'Hérnia inguinal', 'Pólipos intestinais', 'Doença de crohn', 'Hemorroidas', 'Cirrose hepática', 'Icterícia', 'Pancreatite', 'Cancro do pâncreas', 'Insuficiência hepática']
        ]);

        $survey->questions()->create([
            'content' => '21. Tem algum problema no aparelho urinário?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Infeções urinárias', 'Insuficiência renal', 'Cálculos renais', 'Cancro da Bexiga']
        ]);

        $survey->questions()->create([
            'content' => '22. Tem algum problema ou problemas na mama ou no aparelho genital?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Quistos mamários', 'Cancro da mama', 'Cancro do útero', 'Cancro de ovários', 'Cancro da próstata', 'Cancro testicular']
        ]);

        $survey->questions()->create([
            'content' => '23. Tem alguma(s) doença(s) Neurológica(s) ou Mental?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Depressão', 'Epilepsia', 'Paralisia', 'Cefaleias', 'Traumatismo craniano', 'Esclerose Lateral Amiotrófica', 'Esclerose Múltipla']
        ]);

        $survey->questions()->create([
            'content' => '24. Tem alguma(s) doença(s) de Pele?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Cancro de Pele', 'Eczema', 'Urticária', 'Psoríase']
        ]);

        $survey->questions()->create([
            'content' => '25. Tem algum problema de Ossos, de Articulações ou de Músculos?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Hérnia discal', 'Cifose', 'Lordose', 'Escoliose', 'Lombalgia', 'Dor ciática', 'Tendinites', 'Entorse', 'Rotura de ligamentos', 'Artrose ou artrite', 'Reumatismo', 'Fibromialgia', 'Osteoporose']
        ]);

        $survey->questions()->create([
            'content' => '26. Está a tomar algum medicamento para o problema de saúde que tem atualmente?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '27. Atualmente tem uma ocupação profissional?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '28. Na sua ocupação profissional requer longos períodos sentado?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '29. A sua ocupação profissional requer longos períodos de movimentos repetitivos',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '30. A sua ocupação profissional exige que use sapatos de saltos altos ou sapatos sociais?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '31. A sua ocupação profissional causa-lhe ansiedade (stress mental)?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '32. Pratica alguma atividade recreativa ou desportiva (golfe, tênis, esqui, etc.)?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

        $survey->questions()->create([
            'content' => '33. Tem algum passatempo (ler, fazer jardinagem, trabalhar com carros, etc.)?',
            'type' => 'radio',
            'options' => ['Sim', 'Não']
        ]);

    }
}
