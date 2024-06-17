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

        $one = $survey->sections()->create(['name' => 'Secção Um | 1/12']);

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


        $two = $survey->sections()->create(['name' => 'Secção Dois | 2/12']);

        $two->questions()->create([
            'content' => 'Mesmo sabendo desta situação deseja continuar com o questionário?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $three = $survey->sections()->create(['name' => 'Secção Três | 3/12']);

        $three->questions()->create([
            'content' => 'Qual ou quais são os seus motivos para a prática desta atividade?',
            'type' => 'multiselect',
            'options' => ['Diminuição da % de Gordura', 'Definição Muscular', 'Fortalecimento e reabilitação física', 'Melhoraria da postura corporal', 'Prevenção de doenças', 'Evitar o stress e/ou a ansiedade'],
            'rules' => ['nullable']
        ]);

        $four = $survey->sections()->create(['name' => 'Secção Quatro | 4/12']);

        $four->questions()->create([
            'content' => 'Pretende PT ELETROESTIMULAÇÃO? (Treino individualizado, de 30 min. de duração em alta intensidade e acompanhado por um profissional do exercício físico que elabora uma planificação cuidada atendendo às características, necessidades e objetivos específicos do cliente, com a utilização de um fato que transmite impulsos elétricos que estimulam 350 músculos em simultâneo, enquanto realiza os exercícios físicos programados)',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $five = $survey->sections()->create(['name' => 'Secção Cinco | 5/12']);

        $five->questions()->create([
            'content' => 'Tem alguma(s) das situações de saúde mencionadas de seguida?',
            'type' => 'multiselect',
            'options' => ['Nenhuma', 'Gravidez', 'Cancro', 'Tuberculose', 'AVC', 'Doença cardíaca', 'Enfarte', 'Angina de peito', 'Cirrose hepática', 'Insuficiência hepática', 'Pancreatite', 'Icterícia', 'Insuficiência renal', 'Cálculos renais', 'Quistos mamários', 'Epilepsia', 'Psoríase']
        ]);

        $six = $survey->sections()->create(['name' => 'Secção Seis | 6/12']);

        $six->questions()->create([
            'content' => 'Uma vez que o seu estado de saúde impossibilita de poder frequentar a modalidade de PT de Eletroestimulação, pretende frequentar outro serviço?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $seven = $survey->sections()->create(['name' => 'Secção Sete | 7/12']);

        $seven->questions()->create([
            'content' => 'Qual ou quais das Atividades que pretende realizar?',
            'type' => 'multiselect',
            'options' => [
                'PERSONAL TRAINING  (treino individualizado ou de 2/3 clientes em simultâneo acompanhado por um profissional do exercício físico que elabora uma planificação cuidada atendendo às características, necessidades e objetivos específicos de cada cliente, com uma duração de 60 min. por sessão)',
                'PT EQUI. PILATES (Treino personalizado de 60 min., acompanhado por um profissional de exercício físico, que elabora um plano ajustado ás necessidades do cliente com uso de aparelhos de molas que auxiliam na realização dos movimentos)',
                'TREINO FUNCIONAL (Treino em grupo de 60min. acompanhado por um profissional de exercício físico, que elabora um plano constituído por um conjunto de exercícios dinâmicos e cadenciados que procuram os movimentos naturais do ser humano ajustados às funções e tarefas diárias do cliente, trabalhando os músculos de uma forma global e diversificada, através da utilização um diverso número de acessórios como elásticos, bolas, cordas, kettlebells, halteres, barras, ou Racks, etc.)',
                'TREINO LIVRE (Treino funcional de 60 min. sem acompanhamento profissional mas supervisionado por um profissional de exercício físico presente no espaço, onde dentro da disponibilidade material e espacial, o cliente elabora o seu próprio plano de treino)'],
            'rules' => ['nullable']
        ]);

        $eight = $survey->sections()->create(['name' => 'Secção Oito | 8/12']);

        $eight->questions()->create([
            'content' => 'Se é mulher, encontra-se grávida?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);


        $eight->questions()->create([
            'content' => 'Em caso afirmativo diga de quanto tempo?',
            'type' => 'text',
        ]);


        $eight->questions()->create([
            'content' => 'É fumador(a)?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $eight->questions()->create([
            'content' => 'Tem alguma(s) doença(s) endócrina(s), metabólica(s) ou de sangue?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Hemofilia', 'Colesterol Alto', 'Diabetes', 'Problema de Tiroide', 'Bócio', 'Anemia', 'Leucemia', 'Linfoma'],
            'rules' => ['nullable']
        ]);

        $eight->questions()->create([
            'content' => 'Tem algum problema ou problemas no aparelho respiratório?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Alergia', 'Asma', 'Apneia do sono', 'Bronquite', 'Tuberculose', 'Cancro do pulmão'],
            'rules' => ['nullable']
        ]);

        $eight->questions()->create([
            'content' => 'Tem algum problema ou problemas no aparelho circulatório?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Hipertensão arterial', 'Hipotensão arterial', 'Má circulação', 'Varizes', 'Derrames', 'Trombose', 'AVC', 'Doença cardíaca', 'Enfarte', 'Angina de peito', 'Arritmia'],
            'rules' => ['nullable']
        ]);

        $eight->questions()->create([
            'content' => 'Tem algum problema ou problemas no aparelho digestivo?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Gastrite', 'Úlceras', 'Cálculos biliares', 'Refluxo', 'Cancro do estômago', 'Hérnia de hiato', 'Hérnia inguinal', 'Pólipos intestinais', 'Doença de crohn', 'Hemorroidas', 'Cirrose hepática', 'Icterícia', 'Pancreatite', 'Cancro do pâncreas', 'Insuficiência hepática'],
            'rules' => ['nullable']
        ]);

        $eight->questions()->create([
            'content' => 'Tem algum problema no aparelho urinário?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Infeções urinárias', 'Insuficiência renal', 'Cálculos renais', 'Cancro da Bexiga'],
            'rules' => ['nullable']
        ]);

        $eight->questions()->create([
            'content' => 'Tem algum problema ou problemas na mama ou no aparelho genital?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Quistos mamários', 'Cancro da mama', 'Cancro do útero', 'Cancro de ovários', 'Cancro da próstata', 'Cancro testicular'],
            'rules' => ['nullable']
        ]);

        $eight->questions()->create([
            'content' => 'Tem alguma(s) doença(s) Neurológica(s) ou Mental?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Depressão', 'Epilepsia', 'Paralisia', 'Cefaleias', 'Traumatismo craniano', 'Esclerose Lateral Amiotrófica', 'Esclerose Múltipla'],
            'rules' => ['nullable']
        ]);

        $eight->questions()->create([
            'content' => 'Tem alguma(s) doença(s) de Pele?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Cancro de Pele', 'Eczema', 'Urticária', 'Psoríase'],
            'rules' => ['nullable']
        ]);

        $eight->questions()->create([
            'content' => 'Tem algum problema de Ossos, de Articulações ou de Músculos?',
            'type' => 'multiselect',
            'options' => ['Nenhum', 'Hérnia discal', 'Cifose', 'Lordose', 'Escoliose', 'Lombalgia', 'Dor ciática', 'Tendinites', 'Entorse', 'Rotura de ligamentos', 'Artrose ou artrite', 'Reumatismo', 'Fibromialgia', 'Osteoporose'],
            'rules' => ['nullable']
        ]);


        $nine = $survey->sections()->create(['name' => 'Secção Nove | 9/12']);

        $nine->questions()->create([
            'content' => 'Está a tomar algum medicamento para o problema de saúde que tem atualmente?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $nine->questions()->create([
            'content' => 'Liste, por favor os medicamentos que toma.',
            'type' => 'text',
        ]);

        $ten = $survey->sections()->create(['name' => 'Secção Dez | 10/12']);

        $ten->questions()->create([
            'content' => 'Atualmente tem uma ocupação profissional?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $ten->questions()->create([
            'content' => 'Em caso afirmativo, diga qual é?',
            'type' => 'text',
        ]);

        $eleven = $survey->sections()->create(['name' => 'Secção Onze | 11/12']);

        $eleven->questions()->create([
            'content' => 'Na sua ocupação profissional requer longos períodos sentado?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $eleven->questions()->create([
            'content' => 'A sua ocupação profissional requer longos períodos de movimentos repetitivos',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $eleven->questions()->create([
            'content' => 'Em caso afirmativo, explique.',
            'type' => 'text',
        ]);

        $eleven->questions()->create([
            'content' => 'A sua ocupação profissional exige que use sapatos de saltos altos ou sapatos sociais?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $eleven->questions()->create([
            'content' => 'A sua ocupação profissional causa-lhe ansiedade (stress mental)?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $twelve = $survey->sections()->create(['name' => 'Secção Doze | 12/12']);

        $twelve->questions()->create([
            'content' => '32. Pratica alguma atividade recreativa ou desportiva (golfe, tênis, esqui, etc.)?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $twelve->questions()->create([
            'content' => 'Em caso afirmativo, por favor explique.',
            'type' => 'text',
        ]);

        $twelve->questions()->create([
            'content' => '33. Tem algum passatempo (ler, fazer jardinagem, trabalhar com carros, etc.)?',
            'type' => 'radio',
            'options' => ['Sim', 'Não'],
            'rules' => ['nullable']
        ]);

        $twelve->questions()->create([
            'content' => 'Em caso afirmativo, por favor explique.',
            'type' => 'text',
        ]);

    }
}
