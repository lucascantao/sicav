<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setor;

class SetorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setor::create([
            'sigla' => 'AISC',
            'nome' => 'ASSESSORIA ESPECIAL DE SEGURANÇA E INTELIGÊNCIA CORPORATIVA'
        ]);

        Setor::create([
                    'sigla' => 'ASCOM',
                    'nome' => 'ASSESSORIA DE COMUNICAÇÃO'
        ]);

        Setor::create([
                    'sigla' => 'CCON',
                    'nome' => 'COORDENAÇÃO DE CONTROLE, CONTRATOS, CONVÊNIOS E LICITAÇÕES'
        ]);

        Setor::create([
                    'sigla' => 'CEAM',
                    'nome' => 'COORDENADORIA DE EDUCAÇÃO AMBIENTAL'
        ]);

        Setor::create([
                    'sigla' => 'CFISC',
                    'nome' => 'COMITÊ DE MONITORAMENTO E PLANEJAMENTO ESTRATÉGICO PARA FISCALIZAÇÃO (CIMAM)'
        ]);

        Setor::create([
                    'sigla' => 'CGP',
                    'nome' => 'COORDENADORIA DE GESTÃO DE PESSOAS'
        ]);

        Setor::create([
                    'sigla' => 'CIND',
                    'nome' => 'COORDENADORIA DE INDÚSTRIA, COMÉRCIO, SERVIÇOS E RESÍDUOS'
        ]);

        Setor::create([
                    'sigla' => 'CINFAP',
                    'nome' => 'COORDENADORIA DE ENERGIA, INFRAESTRUTURA, FAUNA, AQUICULTURA E PESCA'
        ]);

        Setor::create([
                    'sigla' => 'CMINA',
                    'nome' => 'COORDENADORIA DE MINERAÇÃO E ENERGIA'
        ]);

        Setor::create([
                    'sigla' => 'COAD',
                    'nome' => 'COORDENADORIA ADMINISTRATIVA DE INFRAESTRUTURA E LOGÍSTICA'
        ]);

        Setor::create([
                    'sigla' => 'COEMA',
                    'nome' => 'CONSELHO ESTADUAL DE MONITORAMENTO AMBIENTAL'
        ]);

        Setor::create([
                    'sigla' => 'COFIN',
                    'nome' => 'COORDENADORIA FINANCEIRA CONTÁBIL'
        ]);

        Setor::create([
                    'sigla' => 'COFISC',
                    'nome' => 'COORDENADORIA DE FISCALIZAÇÃO AMBIENTAL'
        ]);

        Setor::create([
                    'sigla' => 'COGAPI',
                    'nome' => 'COODENADORIA DE GESTÃO AGROPASTORIL E INDUSTRIAL'
        ]);

        Setor::create([
                    'sigla' => 'COGEF',
                    'nome' => 'COORDENADORIA DE GESTÃO FLORESTAL'
        ]);

        Setor::create([
                    'sigla' => 'COMAM',
                    'nome' => 'COORDENADORIA DE ORDENAMENTO E DESCENTRALIZAÇÃO DA GESTÃO AMBIENTAL'
        ]);

        Setor::create([
                    'sigla' => 'CONJUR',
                    'nome' => 'CONSULTORIA JURÍDICA'
        ]);

        Setor::create([
                    'sigla' => 'COR',
                    'nome' => 'COORDENADORIA DE REGULAÇÃO'
        ]);

        Setor::create([
                    'sigla' => 'CORREG',
                    'nome' => 'CORREGEDORIA AMBIENTAL'
        ]);

        Setor::create([
                    'sigla' => 'CPLAN',
                    'nome' => 'COORDENADORIA DE PLANEJAMENTO EM RECURSOS HÍDRICOS'
        ]);

        Setor::create([
                    'sigla' => 'CTDS',
                    'nome' => 'COORDENAÇÃO DE TREINAMENTO, DESENVOLVIMENTO E SUSTENTABILIDADE'
        ]);

        Setor::create([
                    'sigla' => 'DGAF',
                    'nome' => 'DIRETORIA DE GESTÃO ADMINISTRATIVA E FINANCEIRA'
        ]);

        Setor::create([
                    'sigla' => 'DGFLOR',
                    'nome' => 'DIRETORIA AGROSSILVIPASTORIL'
        ]);

        Setor::create([
                    'sigla' => 'DGSOCIO',
                    'nome' => 'DIRETORIA DE GESTÃO SOCIOECONÔMICA'
        ]);

        Setor::create([
                    'sigla' => 'DIFISC',
                    'nome' => 'DIRETORIA DE FISCALIZAÇÃO AMBIENTAL'
        ]);

        Setor::create([
                    'sigla' => 'DIGEO',
                    'nome' => 'DIRETORIA DE GEOTECNOLOGIAS'
        ]);

        Setor::create([
                    'sigla' => 'DINURE',
                    'nome' => 'DIRETORIA DE GESTÃO DOS NÚCLEOS REGIONAIS DE REGULARIDADE'
        ]);

        Setor::create([
                    'sigla' => 'DIORED',
                    'nome' => 'DIRETORIA DE ORDENAMENTO, EDUCAÇÃO E DA DESCENTRALIZAÇÃO DA GESTÃO AMBIENTAL'
        ]);

        Setor::create([
                    'sigla' => 'DIREH',
                    'nome' => 'DIRETORIA DE RECURSOS HÍDRICOS'
        ]);

        Setor::create([
                    'sigla' => 'DLA',
                    'nome' => 'DIRETORIA DE LICENCIAMENTO AMBIENTAL'
        ]);

        Setor::create([
                    'sigla' => 'DPC',
                    'nome' => 'DIRETORIA DE PLANEJAMENTO ESTRATÉGICO E PROJETOS CORPORATIVOS'
        ]);

        Setor::create([
                    'sigla' => 'DTI',
                    'nome' => 'DIRETORIA DE TECNOLOGIA DA INFORMAÇÃO'
        ]);

        Setor::create([
                    'sigla' => 'GAB',
                    'nome' => 'GABINETE DO SECRETÁRIO'
        ]);

        Setor::create([
                    'sigla' => 'GAMAM',
                    'nome' => 'GERÊNCIA DE ARTICULAÇÃO E MUNICIPALIZAÇÃO DA GESTÃO AMBIENTAL'
        ]);

        Setor::create([
                    'sigla' => 'GDAM',
                    'nome' => 'GERÊNCIA DE ARTICULAÇÃO DE DIFUSÃO DA EDUCAÇÃO AMBIENTAL'
        ]);

        Setor::create([
                    'sigla' => 'GEAGRO',
                    'nome' => 'GERÊNCIA DE ATIVIDADES AGROPECUÁRIAS'
        ]);

        Setor::create([
                    'sigla' => 'GEAR',
                    'nome' => 'GERÊNCIA DE ADEQUAÇÃO AMBIENTAL RURAL'
        ]);

        Setor::create([
                    'sigla' => 'GEARQ',
                    'nome' => 'GERÊNCIA DE DOCUMENTAÇÃO E ARQUIVO'
        ]);

        Setor::create([
                    'sigla' => 'GEBIB',
                    'nome' => 'GERÊNCIA DE BIBLIOTECA'
        ]);

        Setor::create([
                    'sigla' => 'GECAD',
                    'nome' => 'GERÊNCIA DE CONTROLE E CADASTRO DE RECURSOS HÍDRICOS'
        ]);

        Setor::create([
                    'sigla' => 'GECON',
                    'nome' => 'GERÊNCIA DE CONTROLE, CONTRATOS, CONVÊNIOS E LICITAÇÕES'
        ]);

        Setor::create([
                    'sigla' => 'GECONT',
                    'nome' => 'GERÊNCIA DE CONTABILIDADE'
        ]);

        Setor::create([
                    'sigla' => 'GECOS',
                    'nome' => 'GERÊNCIA DE PROJETOS DE COMÉRCIO E SERVIÇOS'
        ]);

        Setor::create([
                    'sigla' => 'GEFAP',
                    'nome' => 'GERÊNCIA DE FAUNA, FLORA, AQUICULTURA E PESCA'
        ]);

        Setor::create([
                    'sigla' => 'GEFAU',
                    'nome' => 'GERÊNCIA DE FISCALIZAÇÃO DE FAUNA E RECURSOS PESQUEIROS'
        ]);

        Setor::create([
                    'sigla' => 'GEFLOR',
                    'nome' => 'GERÊNCIA DE FISCALIZAÇÃO FLORESTAL'
        ]);

        Setor::create([
                    'sigla' => 'GEIND',
                    'nome' => 'GERÊNCIA DE PROJETOS INDUSTRIAIS'
        ]);

        Setor::create([
                    'sigla' => 'GEINFRA',
                    'nome' => 'GERÊNCIA DE INFRAESTRUTURA DE TRANSPORTE E OBRAS CIVIS'
        ]);

        Setor::create([
                    'sigla' => 'GELIC',
                    'nome' => 'GERÊNCIA DE LICITAÇÕES'
        ]);

        Setor::create([
                    'sigla' => 'GEMAP',
                    'nome' => 'GERÊNCIA DE MATERIAL E PATRIMÔNIO'
        ]);

        Setor::create([
                    'sigla' => 'GEMIM',
                    'nome' => 'GERÊNCIAS DE MINERAIS METÁLICOS'
        ]);

        Setor::create([
                    'sigla' => 'GEMINA',
                    'nome' => 'GERÊNCIA DE MINERAIS NÃO METÁLICOS'
        ]);

        Setor::create([
                    'sigla' => 'GEMUC',
                    'nome' => 'GERÊNCIA DE MUDANCAS CLIMÁTICAS'
        ]);

        Setor::create([
                    'sigla' => 'GEOFI',
                    'nome' => 'GERÊNCIA DE EXECUÇÃO ORCAMENTÁRIA E FINANCEIRA'
        ]);

        Setor::create([
                    'sigla' => 'GEOSIG',
                    'nome' => 'GERÊNCIA DE GESTÃO DE SISTEMAS DE INFORMAÇÕES GEOGRÁFICAS'
        ]);

        Setor::create([
                    'sigla' => 'GEOTEC',
                    'nome' => 'GERÊNCIA DE SUPORTE GEOTECNOLÓGICO AO LICENCIAMENTO'
        ]);

        Setor::create([
                    'sigla' => 'GEOUT',
                    'nome' => 'GERÊNCIA DE OUTORGA'
        ]);

        Setor::create([
                    'sigla' => 'GEPAF',
                    'nome' => 'GERÊNCIA DE PROJETOS FLORESTAIS'
        ]);

        Setor::create([
                    'sigla' => 'GEPAS',
                    'nome' => 'GERÊNCIA DE PARCELAMENTO DO SOLO E SANEAMENTO'
        ]);

        Setor::create([
                    'sigla' => 'GEPAT',
                    'nome' => 'GERÊNCIA DE PROTOCOLO E ATENDIMENTO'
        ]);

        Setor::create([
                    'sigla' => 'GEPLAM',
                    'nome' => 'GERÊNCIA DE PLANEJAMENTO AMBIENTAL RURAL'
        ]);

        Setor::create([
                    'sigla' => 'GEPLANO',
                    'nome' => 'GERÊNCIA DE PLANEJAMENTO, ORÇAMENTO E FINANCEIRO'
        ]);

        Setor::create([
                    'sigla' => 'GEPLEN',
                    'nome' => 'GERÊNCIA DE PLANOS E ENQUADRAMENTO'
        ]);

        Setor::create([
                    'sigla' => 'GEPROF',
                    'nome' => 'GERÊNCIA DE PROJETOS DE PROCESSAMENTO DE PRODUTOS E SUBPRODUTOS FLORESTAIS'
        ]);

        Setor::create([
                    'sigla' => 'GERAD',
                    'nome' => 'GERÊNCIA DE FISCALIZAÇÃO DE ATIVIDADES POLUIDORAS E DEGRADADORAS'
        ]);

        Setor::create([
                    'sigla' => 'GERCOZ',
                    'nome' => 'GERÊNCIA DE GERENCIAMENTO COSTEIRO E ZONEAMENTO AMBIENTAL'
        ]);

        Setor::create([
                    'sigla' => 'GEREH',
                    'nome' => 'GERÊNCIA DA REDE HIDROMETEOROLÓGICA'
        ]);

        Setor::create([
                    'sigla' => 'GESER',
                    'nome' => 'GERÊNCIA DE INFRAESTRUTURA E SERVIÇOS GERAIS'
        ]);

        Setor::create([
                    'sigla' => 'GESFLORA',
                    'nome' => 'GERÊNCIA DE CADASTRO, TRANSPORTE E COMERCIALIZAÇÃO DE PRODUTOS E SUBPRODUTOS FLORESTAIS'
        ]);

        Setor::create([
                    'sigla' => 'GESIR',
                    'nome' => 'GERÊNCIA DO SISTEMA DE INFORMAÇÕES SOBRE RECURSOS HÍDRICOS'
        ]);

        Setor::create([
                    'sigla' => 'GESIS',
                    'nome' => 'GERÊNCIA DE DESENVOLVIMENTO DE SISTEMAS'
        ]);

        Setor::create([
                    'sigla' => 'GESUP',
                    'nome' => 'GERÊNCIA DE SUPORTE AO USUÁRIO'
        ]);

        Setor::create([
                    'sigla' => 'GETEM',
                    'nome' => 'GERÊNCIA DE MONITORAMENTO DE TEMPO, CLIMA E EVENTOS EXTERNOS HIDROMETEOROLÓGICOS'
        ]);

        Setor::create([
                    'sigla' => 'GPEAM',
                    'nome' => 'GERÊNCIA DE PROGRAMAS E PROJETOS DE EDUCAÇÃO AMBIENTAL'
        ]);

        Setor::create([
                    'sigla' => 'GRECO',
                    'nome' => 'GERÊNCIA DE REDES E COMUNICAÇÃO'
        ]);

        Setor::create([
                    'sigla' => 'GRH',
                    'nome' => 'GERÊNCIA DE RECURSOS HUMANOS'
        ]);

        Setor::create([
                    'sigla' => 'GTDI',
                    'nome' => 'GERÊNCIA DE TRATAMENTO DIGITAL DE IMAGENS E SUPORTE A'
        ]);

        Setor::create([
                    'sigla' => 'JULG',
                    'nome' => 'JULGADORIA'
        ]);

        Setor::create([
                    'sigla' => 'NCI',
                    'nome' => 'NÚCLEO DE CONTROLE INTERNO'
        ]);

        Setor::create([
                    'sigla' => 'NEL',
                    'nome' => 'NÚCLEO DE ESTUDOS LEGISLATIVOS'
        ]);

        Setor::create([
                    'sigla' => 'NMH',
                    'nome' => 'NÚCLEO DE MONITORAMENTO HIDROMETEREOLÓGICO'
        ]);

        Setor::create([
                    'sigla' => 'NUARC',
                    'nome' => 'NÚCLEO DE ARRECADAÇÃO'
        ]);

        Setor::create([
                    'sigla' => 'NUCAM',
                    'nome' => 'NÚCLEO DE CONCILIAÇÃO AMBIENTAL'
        ]);

        Setor::create([
                    'sigla' => 'NUGAC',
                    'nome' => 'NÚCLEO DE GOVERNANÇA DA ÁGUA E DO CLIMA'
        ]);

        Setor::create([
                    'sigla' => 'NURE ALTAMIRA',
                    'nome' => 'NÚCLEO REGIONAL DE ALTAMIRA'
        ]);

        Setor::create([
                    'sigla' => 'NURE MARABÁ',
                    'nome' => 'NÚCLEO REGIONAL DE MARABÁ'
        ]);

        Setor::create([
                    'sigla' => 'NURE REDENÇÃO',
                    'nome' => 'NÚCLEO REGIONAL DE REDENÇÃO'
        ]);

        Setor::create([
                    'sigla' => 'NURE ITAITUBA',
                    'nome' => 'NÚCLEO REGIONAL DE ITAITUBA'
        ]);

        Setor::create([
                    'sigla' => 'NURE SANTARÉM',
                    'nome' => 'NÚCLEO REGIONAL DE SANTARÉM'
        ]);

        Setor::create([
                    'sigla' => 'NURE PARAGOMINAS',
                    'nome' => 'NÚCLEO REGIONAL DE PARAGOMINAS'
        ]);

        Setor::create([
                    'sigla' => 'OUVID',
                    'nome' => 'OUVIDORIA AMBIENTAL'
        ]);

        Setor::create([
                    'sigla' => 'SAGAT',
                    'nome' => 'SECRETARIA ADJUNTA DE GESTÃO ADMINISTRATIVA E TECNOLOGIAS'
        ]);

        Setor::create([
                    'sigla' => 'SAGRA',
                    'nome' => 'SECRETARIA ADJUNTA DE GESTÃO E REGULARIDADE AMBIENTAL'
        ]);

        Setor::create([
                    'sigla' => 'SAGRH',
                    'nome' => 'SECRETARIA ADJUNTA DE GESTÃO DE RECURSOS HÍDRICOS E CLIMA'
        ]);

        Setor::create([
                    'sigla' => 'SBPA',
                    'nome' => 'SETOR DE BENS E PRODUTOS APREENDIDOS'
        ]);



        
    }
}
