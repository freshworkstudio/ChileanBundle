<?php

declare(strict_types=1);

namespace Freshwork\ChileanBundle;

/**
 * The 346 comunas of Chile, backed by their official territorial code
 * (Código Único Territorial, CUT — SUBDERE). The first digits of the
 * code are the region number.
 *
 * Source: SUBDERE, Planilla Códigos Únicos Territoriales (CUT_2018_v04).
 */
enum Comuna: int
{
    // Tarapacá
    case Iquique = 1101;
    case AltoHospicio = 1107;
    case PozoAlmonte = 1401;
    case Camina = 1402;
    case Colchane = 1403;
    case Huara = 1404;
    case Pica = 1405;

    // Antofagasta
    case Antofagasta = 2101;
    case Mejillones = 2102;
    case SierraGorda = 2103;
    case Taltal = 2104;
    case Calama = 2201;
    case Ollague = 2202;
    case SanPedroDeAtacama = 2203;
    case Tocopilla = 2301;
    case MariaElena = 2302;

    // Atacama
    case Copiapo = 3101;
    case Caldera = 3102;
    case TierraAmarilla = 3103;
    case Chanaral = 3201;
    case DiegoDeAlmagro = 3202;
    case Vallenar = 3301;
    case AltoDelCarmen = 3302;
    case Freirina = 3303;
    case Huasco = 3304;

    // Coquimbo
    case LaSerena = 4101;
    case Coquimbo = 4102;
    case Andacollo = 4103;
    case LaHiguera = 4104;
    case Paiguano = 4105;
    case Vicuna = 4106;
    case Illapel = 4201;
    case Canela = 4202;
    case LosVilos = 4203;
    case Salamanca = 4204;
    case Ovalle = 4301;
    case Combarbala = 4302;
    case MontePatria = 4303;
    case Punitaqui = 4304;
    case RioHurtado = 4305;

    // Valparaíso
    case Valparaiso = 5101;
    case Casablanca = 5102;
    case Concon = 5103;
    case JuanFernandez = 5104;
    case Puchuncavi = 5105;
    case Quintero = 5107;
    case VinaDelMar = 5109;
    case IslaDePascua = 5201;
    case LosAndes = 5301;
    case CalleLarga = 5302;
    case Rinconada = 5303;
    case SanEsteban = 5304;
    case LaLigua = 5401;
    case Cabildo = 5402;
    case Papudo = 5403;
    case Petorca = 5404;
    case Zapallar = 5405;
    case Quillota = 5501;
    case Calera = 5502;
    case Hijuelas = 5503;
    case LaCruz = 5504;
    case Nogales = 5506;
    case SanAntonio = 5601;
    case Algarrobo = 5602;
    case Cartagena = 5603;
    case ElQuisco = 5604;
    case ElTabo = 5605;
    case SantoDomingo = 5606;
    case SanFelipe = 5701;
    case Catemu = 5702;
    case Llaillay = 5703;
    case Panquehue = 5704;
    case Putaendo = 5705;
    case SantaMaria = 5706;
    case Quilpue = 5801;
    case Limache = 5802;
    case Olmue = 5803;
    case VillaAlemana = 5804;

    // Libertador General Bernardo O'Higgins
    case Rancagua = 6101;
    case Codegua = 6102;
    case Coinco = 6103;
    case Coltauco = 6104;
    case Donihue = 6105;
    case Graneros = 6106;
    case LasCabras = 6107;
    case Machali = 6108;
    case Malloa = 6109;
    case Mostazal = 6110;
    case Olivar = 6111;
    case Peumo = 6112;
    case Pichidegua = 6113;
    case QuintaDeTilcoco = 6114;
    case Rengo = 6115;
    case Requinoa = 6116;
    case SanVicente = 6117;
    case Pichilemu = 6201;
    case LaEstrella = 6202;
    case Litueche = 6203;
    case Marchihue = 6204;
    case Navidad = 6205;
    case Paredones = 6206;
    case SanFernando = 6301;
    case Chepica = 6302;
    case Chimbarongo = 6303;
    case Lolol = 6304;
    case Nancagua = 6305;
    case Palmilla = 6306;
    case Peralillo = 6307;
    case Placilla = 6308;
    case Pumanque = 6309;
    case SantaCruz = 6310;

    // Maule
    case Talca = 7101;
    case Constitucion = 7102;
    case Curepto = 7103;
    case Empedrado = 7104;
    case Maule = 7105;
    case Pelarco = 7106;
    case Pencahue = 7107;
    case RioClaro = 7108;
    case SanClemente = 7109;
    case SanRafael = 7110;
    case Cauquenes = 7201;
    case Chanco = 7202;
    case Pelluhue = 7203;
    case Curico = 7301;
    case Hualane = 7302;
    case Licanten = 7303;
    case Molina = 7304;
    case Rauco = 7305;
    case Romeral = 7306;
    case SagradaFamilia = 7307;
    case Teno = 7308;
    case Vichuquen = 7309;
    case Linares = 7401;
    case Colbun = 7402;
    case Longavi = 7403;
    case Parral = 7404;
    case Retiro = 7405;
    case SanJavier = 7406;
    case VillaAlegre = 7407;
    case YerbasBuenas = 7408;

    // Biobío
    case Concepcion = 8101;
    case Coronel = 8102;
    case Chiguayante = 8103;
    case Florida = 8104;
    case Hualqui = 8105;
    case Lota = 8106;
    case Penco = 8107;
    case SanPedroDeLaPaz = 8108;
    case SantaJuana = 8109;
    case Talcahuano = 8110;
    case Tome = 8111;
    case Hualpen = 8112;
    case Lebu = 8201;
    case Arauco = 8202;
    case Canete = 8203;
    case Contulmo = 8204;
    case Curanilahue = 8205;
    case LosAlamos = 8206;
    case Tirua = 8207;
    case LosAngeles = 8301;
    case Antuco = 8302;
    case Cabrero = 8303;
    case Laja = 8304;
    case Mulchen = 8305;
    case Nacimiento = 8306;
    case Negrete = 8307;
    case Quilaco = 8308;
    case Quilleco = 8309;
    case SanRosendo = 8310;
    case SantaBarbara = 8311;
    case Tucapel = 8312;
    case Yumbel = 8313;
    case AltoBiobio = 8314;

    // La Araucanía
    case Temuco = 9101;
    case Carahue = 9102;
    case Cunco = 9103;
    case Curarrehue = 9104;
    case Freire = 9105;
    case Galvarino = 9106;
    case Gorbea = 9107;
    case Lautaro = 9108;
    case Loncoche = 9109;
    case Melipeuco = 9110;
    case NuevaImperial = 9111;
    case PadreLasCasas = 9112;
    case Perquenco = 9113;
    case Pitrufquen = 9114;
    case Pucon = 9115;
    case Saavedra = 9116;
    case TeodoroSchmidt = 9117;
    case Tolten = 9118;
    case Vilcun = 9119;
    case Villarrica = 9120;
    case Cholchol = 9121;
    case Angol = 9201;
    case Collipulli = 9202;
    case Curacautin = 9203;
    case Ercilla = 9204;
    case Lonquimay = 9205;
    case LosSauces = 9206;
    case Lumaco = 9207;
    case Puren = 9208;
    case Renaico = 9209;
    case Traiguen = 9210;
    case Victoria = 9211;

    // Los Lagos
    case PuertoMontt = 10101;
    case Calbuco = 10102;
    case Cochamo = 10103;
    case Fresia = 10104;
    case Frutillar = 10105;
    case LosMuermos = 10106;
    case Llanquihue = 10107;
    case Maullin = 10108;
    case PuertoVaras = 10109;
    case Castro = 10201;
    case Ancud = 10202;
    case Chonchi = 10203;
    case CuracoDeVelez = 10204;
    case Dalcahue = 10205;
    case Puqueldon = 10206;
    case Queilen = 10207;
    case Quellon = 10208;
    case Quemchi = 10209;
    case Quinchao = 10210;
    case Osorno = 10301;
    case PuertoOctay = 10302;
    case Purranque = 10303;
    case Puyehue = 10304;
    case RioNegro = 10305;
    case SanJuanDeLaCosta = 10306;
    case SanPablo = 10307;
    case Chaiten = 10401;
    case Futaleufu = 10402;
    case Hualaihue = 10403;
    case Palena = 10404;

    // Aysén del General Carlos Ibáñez del Campo
    case Coyhaique = 11101;
    case LagoVerde = 11102;
    case Aysen = 11201;
    case Cisnes = 11202;
    case Guaitecas = 11203;
    case Cochrane = 11301;
    case OHiggins = 11302;
    case Tortel = 11303;
    case ChileChico = 11401;
    case RioIbanez = 11402;

    // Magallanes y de la Antártica Chilena
    case PuntaArenas = 12101;
    case LagunaBlanca = 12102;
    case RioVerde = 12103;
    case SanGregorio = 12104;
    case CaboDeHornos = 12201;
    case Antartica = 12202;
    case Porvenir = 12301;
    case Primavera = 12302;
    case Timaukel = 12303;
    case Natales = 12401;
    case TorresDelPaine = 12402;

    // Metropolitana de Santiago
    case Santiago = 13101;
    case Cerrillos = 13102;
    case CerroNavia = 13103;
    case Conchali = 13104;
    case ElBosque = 13105;
    case EstacionCentral = 13106;
    case Huechuraba = 13107;
    case Independencia = 13108;
    case LaCisterna = 13109;
    case LaFlorida = 13110;
    case LaGranja = 13111;
    case LaPintana = 13112;
    case LaReina = 13113;
    case LasCondes = 13114;
    case LoBarnechea = 13115;
    case LoEspejo = 13116;
    case LoPrado = 13117;
    case Macul = 13118;
    case Maipu = 13119;
    case Nunoa = 13120;
    case PedroAguirreCerda = 13121;
    case Penalolen = 13122;
    case Providencia = 13123;
    case Pudahuel = 13124;
    case Quilicura = 13125;
    case QuintaNormal = 13126;
    case Recoleta = 13127;
    case Renca = 13128;
    case SanJoaquin = 13129;
    case SanMiguel = 13130;
    case SanRamon = 13131;
    case Vitacura = 13132;
    case PuenteAlto = 13201;
    case Pirque = 13202;
    case SanJoseDeMaipo = 13203;
    case Colina = 13301;
    case Lampa = 13302;
    case Tiltil = 13303;
    case SanBernardo = 13401;
    case Buin = 13402;
    case CaleraDeTango = 13403;
    case Paine = 13404;
    case Melipilla = 13501;
    case Alhue = 13502;
    case Curacavi = 13503;
    case MariaPinto = 13504;
    case SanPedro = 13505;
    case Talagante = 13601;
    case ElMonte = 13602;
    case IslaDeMaipo = 13603;
    case PadreHurtado = 13604;
    case Penaflor = 13605;

    // Los Ríos
    case Valdivia = 14101;
    case Corral = 14102;
    case Lanco = 14103;
    case LosLagos = 14104;
    case Mafil = 14105;
    case Mariquina = 14106;
    case Paillaco = 14107;
    case Panguipulli = 14108;
    case LaUnion = 14201;
    case Futrono = 14202;
    case LagoRanco = 14203;
    case RioBueno = 14204;

    // Arica y Parinacota
    case Arica = 15101;
    case Camarones = 15102;
    case Putre = 15201;
    case GeneralLagos = 15202;

    // Ñuble
    case Chillan = 16101;
    case Bulnes = 16102;
    case ChillanViejo = 16103;
    case ElCarmen = 16104;
    case Pemuco = 16105;
    case Pinto = 16106;
    case Quillon = 16107;
    case SanIgnacio = 16108;
    case Yungay = 16109;
    case Quirihue = 16201;
    case Cobquecura = 16202;
    case Coelemu = 16203;
    case Ninhue = 16204;
    case Portezuelo = 16205;
    case Ranquil = 16206;
    case Treguaco = 16207;
    case SanCarlos = 16301;
    case Coihueco = 16302;
    case Niquen = 16303;
    case SanFabian = 16304;
    case SanNicolas = 16305;

    /**
     * Official name of the comuna.
     */
    public function officialName(): string
    {
        return match ($this) {
            self::Iquique => 'Iquique',
            self::AltoHospicio => 'Alto Hospicio',
            self::PozoAlmonte => 'Pozo Almonte',
            self::Camina => 'Camiña',
            self::Colchane => 'Colchane',
            self::Huara => 'Huara',
            self::Pica => 'Pica',
            self::Antofagasta => 'Antofagasta',
            self::Mejillones => 'Mejillones',
            self::SierraGorda => 'Sierra Gorda',
            self::Taltal => 'Taltal',
            self::Calama => 'Calama',
            self::Ollague => 'Ollagüe',
            self::SanPedroDeAtacama => 'San Pedro de Atacama',
            self::Tocopilla => 'Tocopilla',
            self::MariaElena => 'María Elena',
            self::Copiapo => 'Copiapó',
            self::Caldera => 'Caldera',
            self::TierraAmarilla => 'Tierra Amarilla',
            self::Chanaral => 'Chañaral',
            self::DiegoDeAlmagro => 'Diego de Almagro',
            self::Vallenar => 'Vallenar',
            self::AltoDelCarmen => 'Alto del Carmen',
            self::Freirina => 'Freirina',
            self::Huasco => 'Huasco',
            self::LaSerena => 'La Serena',
            self::Coquimbo => 'Coquimbo',
            self::Andacollo => 'Andacollo',
            self::LaHiguera => 'La Higuera',
            self::Paiguano => 'Paiguano',
            self::Vicuna => 'Vicuña',
            self::Illapel => 'Illapel',
            self::Canela => 'Canela',
            self::LosVilos => 'Los Vilos',
            self::Salamanca => 'Salamanca',
            self::Ovalle => 'Ovalle',
            self::Combarbala => 'Combarbalá',
            self::MontePatria => 'Monte Patria',
            self::Punitaqui => 'Punitaqui',
            self::RioHurtado => 'Río Hurtado',
            self::Valparaiso => 'Valparaíso',
            self::Casablanca => 'Casablanca',
            self::Concon => 'Concón',
            self::JuanFernandez => 'Juan Fernández',
            self::Puchuncavi => 'Puchuncaví',
            self::Quintero => 'Quintero',
            self::VinaDelMar => 'Viña del Mar',
            self::IslaDePascua => 'Isla de Pascua',
            self::LosAndes => 'Los Andes',
            self::CalleLarga => 'Calle Larga',
            self::Rinconada => 'Rinconada',
            self::SanEsteban => 'San Esteban',
            self::LaLigua => 'La Ligua',
            self::Cabildo => 'Cabildo',
            self::Papudo => 'Papudo',
            self::Petorca => 'Petorca',
            self::Zapallar => 'Zapallar',
            self::Quillota => 'Quillota',
            self::Calera => 'Calera',
            self::Hijuelas => 'Hijuelas',
            self::LaCruz => 'La Cruz',
            self::Nogales => 'Nogales',
            self::SanAntonio => 'San Antonio',
            self::Algarrobo => 'Algarrobo',
            self::Cartagena => 'Cartagena',
            self::ElQuisco => 'El Quisco',
            self::ElTabo => 'El Tabo',
            self::SantoDomingo => 'Santo Domingo',
            self::SanFelipe => 'San Felipe',
            self::Catemu => 'Catemu',
            self::Llaillay => 'Llaillay',
            self::Panquehue => 'Panquehue',
            self::Putaendo => 'Putaendo',
            self::SantaMaria => 'Santa María',
            self::Quilpue => 'Quilpué',
            self::Limache => 'Limache',
            self::Olmue => 'Olmué',
            self::VillaAlemana => 'Villa Alemana',
            self::Rancagua => 'Rancagua',
            self::Codegua => 'Codegua',
            self::Coinco => 'Coinco',
            self::Coltauco => 'Coltauco',
            self::Donihue => 'Doñihue',
            self::Graneros => 'Graneros',
            self::LasCabras => 'Las Cabras',
            self::Machali => 'Machalí',
            self::Malloa => 'Malloa',
            self::Mostazal => 'Mostazal',
            self::Olivar => 'Olivar',
            self::Peumo => 'Peumo',
            self::Pichidegua => 'Pichidegua',
            self::QuintaDeTilcoco => 'Quinta de Tilcoco',
            self::Rengo => 'Rengo',
            self::Requinoa => 'Requínoa',
            self::SanVicente => 'San Vicente',
            self::Pichilemu => 'Pichilemu',
            self::LaEstrella => 'La Estrella',
            self::Litueche => 'Litueche',
            self::Marchihue => 'Marchihue',
            self::Navidad => 'Navidad',
            self::Paredones => 'Paredones',
            self::SanFernando => 'San Fernando',
            self::Chepica => 'Chépica',
            self::Chimbarongo => 'Chimbarongo',
            self::Lolol => 'Lolol',
            self::Nancagua => 'Nancagua',
            self::Palmilla => 'Palmilla',
            self::Peralillo => 'Peralillo',
            self::Placilla => 'Placilla',
            self::Pumanque => 'Pumanque',
            self::SantaCruz => 'Santa Cruz',
            self::Talca => 'Talca',
            self::Constitucion => 'Constitución',
            self::Curepto => 'Curepto',
            self::Empedrado => 'Empedrado',
            self::Maule => 'Maule',
            self::Pelarco => 'Pelarco',
            self::Pencahue => 'Pencahue',
            self::RioClaro => 'Río Claro',
            self::SanClemente => 'San Clemente',
            self::SanRafael => 'San Rafael',
            self::Cauquenes => 'Cauquenes',
            self::Chanco => 'Chanco',
            self::Pelluhue => 'Pelluhue',
            self::Curico => 'Curicó',
            self::Hualane => 'Hualañé',
            self::Licanten => 'Licantén',
            self::Molina => 'Molina',
            self::Rauco => 'Rauco',
            self::Romeral => 'Romeral',
            self::SagradaFamilia => 'Sagrada Familia',
            self::Teno => 'Teno',
            self::Vichuquen => 'Vichuquén',
            self::Linares => 'Linares',
            self::Colbun => 'Colbún',
            self::Longavi => 'Longaví',
            self::Parral => 'Parral',
            self::Retiro => 'Retiro',
            self::SanJavier => 'San Javier',
            self::VillaAlegre => 'Villa Alegre',
            self::YerbasBuenas => 'Yerbas Buenas',
            self::Concepcion => 'Concepción',
            self::Coronel => 'Coronel',
            self::Chiguayante => 'Chiguayante',
            self::Florida => 'Florida',
            self::Hualqui => 'Hualqui',
            self::Lota => 'Lota',
            self::Penco => 'Penco',
            self::SanPedroDeLaPaz => 'San Pedro de la Paz',
            self::SantaJuana => 'Santa Juana',
            self::Talcahuano => 'Talcahuano',
            self::Tome => 'Tomé',
            self::Hualpen => 'Hualpén',
            self::Lebu => 'Lebu',
            self::Arauco => 'Arauco',
            self::Canete => 'Cañete',
            self::Contulmo => 'Contulmo',
            self::Curanilahue => 'Curanilahue',
            self::LosAlamos => 'Los Álamos',
            self::Tirua => 'Tirúa',
            self::LosAngeles => 'Los Ángeles',
            self::Antuco => 'Antuco',
            self::Cabrero => 'Cabrero',
            self::Laja => 'Laja',
            self::Mulchen => 'Mulchén',
            self::Nacimiento => 'Nacimiento',
            self::Negrete => 'Negrete',
            self::Quilaco => 'Quilaco',
            self::Quilleco => 'Quilleco',
            self::SanRosendo => 'San Rosendo',
            self::SantaBarbara => 'Santa Bárbara',
            self::Tucapel => 'Tucapel',
            self::Yumbel => 'Yumbel',
            self::AltoBiobio => 'Alto Biobío',
            self::Temuco => 'Temuco',
            self::Carahue => 'Carahue',
            self::Cunco => 'Cunco',
            self::Curarrehue => 'Curarrehue',
            self::Freire => 'Freire',
            self::Galvarino => 'Galvarino',
            self::Gorbea => 'Gorbea',
            self::Lautaro => 'Lautaro',
            self::Loncoche => 'Loncoche',
            self::Melipeuco => 'Melipeuco',
            self::NuevaImperial => 'Nueva Imperial',
            self::PadreLasCasas => 'Padre Las Casas',
            self::Perquenco => 'Perquenco',
            self::Pitrufquen => 'Pitrufquén',
            self::Pucon => 'Pucón',
            self::Saavedra => 'Saavedra',
            self::TeodoroSchmidt => 'Teodoro Schmidt',
            self::Tolten => 'Toltén',
            self::Vilcun => 'Vilcún',
            self::Villarrica => 'Villarrica',
            self::Cholchol => 'Cholchol',
            self::Angol => 'Angol',
            self::Collipulli => 'Collipulli',
            self::Curacautin => 'Curacautín',
            self::Ercilla => 'Ercilla',
            self::Lonquimay => 'Lonquimay',
            self::LosSauces => 'Los Sauces',
            self::Lumaco => 'Lumaco',
            self::Puren => 'Purén',
            self::Renaico => 'Renaico',
            self::Traiguen => 'Traiguén',
            self::Victoria => 'Victoria',
            self::PuertoMontt => 'Puerto Montt',
            self::Calbuco => 'Calbuco',
            self::Cochamo => 'Cochamó',
            self::Fresia => 'Fresia',
            self::Frutillar => 'Frutillar',
            self::LosMuermos => 'Los Muermos',
            self::Llanquihue => 'Llanquihue',
            self::Maullin => 'Maullín',
            self::PuertoVaras => 'Puerto Varas',
            self::Castro => 'Castro',
            self::Ancud => 'Ancud',
            self::Chonchi => 'Chonchi',
            self::CuracoDeVelez => 'Curaco de Vélez',
            self::Dalcahue => 'Dalcahue',
            self::Puqueldon => 'Puqueldón',
            self::Queilen => 'Queilén',
            self::Quellon => 'Quellón',
            self::Quemchi => 'Quemchi',
            self::Quinchao => 'Quinchao',
            self::Osorno => 'Osorno',
            self::PuertoOctay => 'Puerto Octay',
            self::Purranque => 'Purranque',
            self::Puyehue => 'Puyehue',
            self::RioNegro => 'Río Negro',
            self::SanJuanDeLaCosta => 'San Juan de la Costa',
            self::SanPablo => 'San Pablo',
            self::Chaiten => 'Chaitén',
            self::Futaleufu => 'Futaleufú',
            self::Hualaihue => 'Hualaihué',
            self::Palena => 'Palena',
            self::Coyhaique => 'Coyhaique',
            self::LagoVerde => 'Lago Verde',
            self::Aysen => 'Aysén',
            self::Cisnes => 'Cisnes',
            self::Guaitecas => 'Guaitecas',
            self::Cochrane => 'Cochrane',
            self::OHiggins => 'O\'Higgins',
            self::Tortel => 'Tortel',
            self::ChileChico => 'Chile Chico',
            self::RioIbanez => 'Río Ibáñez',
            self::PuntaArenas => 'Punta Arenas',
            self::LagunaBlanca => 'Laguna Blanca',
            self::RioVerde => 'Río Verde',
            self::SanGregorio => 'San Gregorio',
            self::CaboDeHornos => 'Cabo de Hornos',
            self::Antartica => 'Antártica',
            self::Porvenir => 'Porvenir',
            self::Primavera => 'Primavera',
            self::Timaukel => 'Timaukel',
            self::Natales => 'Natales',
            self::TorresDelPaine => 'Torres del Paine',
            self::Santiago => 'Santiago',
            self::Cerrillos => 'Cerrillos',
            self::CerroNavia => 'Cerro Navia',
            self::Conchali => 'Conchalí',
            self::ElBosque => 'El Bosque',
            self::EstacionCentral => 'Estación Central',
            self::Huechuraba => 'Huechuraba',
            self::Independencia => 'Independencia',
            self::LaCisterna => 'La Cisterna',
            self::LaFlorida => 'La Florida',
            self::LaGranja => 'La Granja',
            self::LaPintana => 'La Pintana',
            self::LaReina => 'La Reina',
            self::LasCondes => 'Las Condes',
            self::LoBarnechea => 'Lo Barnechea',
            self::LoEspejo => 'Lo Espejo',
            self::LoPrado => 'Lo Prado',
            self::Macul => 'Macul',
            self::Maipu => 'Maipú',
            self::Nunoa => 'Ñuñoa',
            self::PedroAguirreCerda => 'Pedro Aguirre Cerda',
            self::Penalolen => 'Peñalolén',
            self::Providencia => 'Providencia',
            self::Pudahuel => 'Pudahuel',
            self::Quilicura => 'Quilicura',
            self::QuintaNormal => 'Quinta Normal',
            self::Recoleta => 'Recoleta',
            self::Renca => 'Renca',
            self::SanJoaquin => 'San Joaquín',
            self::SanMiguel => 'San Miguel',
            self::SanRamon => 'San Ramón',
            self::Vitacura => 'Vitacura',
            self::PuenteAlto => 'Puente Alto',
            self::Pirque => 'Pirque',
            self::SanJoseDeMaipo => 'San José de Maipo',
            self::Colina => 'Colina',
            self::Lampa => 'Lampa',
            self::Tiltil => 'Tiltil',
            self::SanBernardo => 'San Bernardo',
            self::Buin => 'Buin',
            self::CaleraDeTango => 'Calera de Tango',
            self::Paine => 'Paine',
            self::Melipilla => 'Melipilla',
            self::Alhue => 'Alhué',
            self::Curacavi => 'Curacaví',
            self::MariaPinto => 'María Pinto',
            self::SanPedro => 'San Pedro',
            self::Talagante => 'Talagante',
            self::ElMonte => 'El Monte',
            self::IslaDeMaipo => 'Isla de Maipo',
            self::PadreHurtado => 'Padre Hurtado',
            self::Penaflor => 'Peñaflor',
            self::Valdivia => 'Valdivia',
            self::Corral => 'Corral',
            self::Lanco => 'Lanco',
            self::LosLagos => 'Los Lagos',
            self::Mafil => 'Máfil',
            self::Mariquina => 'Mariquina',
            self::Paillaco => 'Paillaco',
            self::Panguipulli => 'Panguipulli',
            self::LaUnion => 'La Unión',
            self::Futrono => 'Futrono',
            self::LagoRanco => 'Lago Ranco',
            self::RioBueno => 'Río Bueno',
            self::Arica => 'Arica',
            self::Camarones => 'Camarones',
            self::Putre => 'Putre',
            self::GeneralLagos => 'General Lagos',
            self::Chillan => 'Chillán',
            self::Bulnes => 'Bulnes',
            self::ChillanViejo => 'Chillán Viejo',
            self::ElCarmen => 'El Carmen',
            self::Pemuco => 'Pemuco',
            self::Pinto => 'Pinto',
            self::Quillon => 'Quillón',
            self::SanIgnacio => 'San Ignacio',
            self::Yungay => 'Yungay',
            self::Quirihue => 'Quirihue',
            self::Cobquecura => 'Cobquecura',
            self::Coelemu => 'Coelemu',
            self::Ninhue => 'Ninhue',
            self::Portezuelo => 'Portezuelo',
            self::Ranquil => 'Ranquil',
            self::Treguaco => 'Treguaco',
            self::SanCarlos => 'San Carlos',
            self::Coihueco => 'Coihueco',
            self::Niquen => 'Ñiquén',
            self::SanFabian => 'San Fabián',
            self::SanNicolas => 'San Nicolás',
        };
    }

    /**
     * The region this comuna belongs to, derived from the territorial code.
     */
    public function region(): Region
    {
        return Region::from(intdiv($this->value, 1000));
    }

    /**
     * The zero-padded, five-digit CUT code as used in official documents. Ex: '01101'.
     */
    public function code(): string
    {
        return str_pad((string) $this->value, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Find a comuna by name (case and accent insensitive). Ex: Comuna::fromName('Ñuñoa').
     */
    public static function fromName(string $name): ?self
    {
        $needle = self::normalizeName($name);
        foreach (self::cases() as $comuna) {
            if (self::normalizeName($comuna->officialName()) === $needle) {
                return $comuna;
            }
        }

        return null;
    }

    /**
     * All comunas of a region.
     *
     * @return self[]
     */
    public static function inRegion(Region $region): array
    {
        return array_values(array_filter(
            self::cases(),
            fn (self $comuna): bool => $comuna->region() === $region
        ));
    }

    /**
     * Comunas as an array suitable for HTML selects: [value => official name].
     * Optionally filtered by region.
     *
     * @return array<int, string>
     */
    public static function options(?Region $region = null): array
    {
        $options = [];
        foreach ($region === null ? self::cases() : self::inRegion($region) as $comuna) {
            $options[$comuna->value] = $comuna->officialName();
        }

        return $options;
    }

    protected static function normalizeName(string $name): string
    {
        $name = mb_strtolower(trim($name));
        $name = strtr($name, ['á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n']);

        return (string) preg_replace('/[^a-z0-9]/', '', $name);
    }
}
