<?php

namespace inoui_ecomm\controllers_admin;


use \lithium\g11n\Message;
use inoui_admin\models\Categories;
use \inoui_ecomm\models\Products;
use \inoui\models\Media;
use \inoui\models\Channels;
use inoui_cms\models\Pages;
use MongoId;

class ProductsController extends \inoui_admin\extensions\action\AdminController {


    public function _init() {
        $this->_render['negotiate'] = true;
        parent::_init();
        $this->_breadcrumbs['Dashboard'] = array('Dashboard::index', 'library'=>'inoui_admin');
    }

	public function index() {
        $this->_breadcrumbs['Products'] = array('Products::index');
		$conditions = array();
		if (count($this->request->params['args'])) {
			$slug = $this->request->params['args'][0];
			$category = Categories::find('first', array('conditions'=>array('slug'=>$slug)));
			$conditions['category_id'] = (string)$category->_id;			
		}
		// $conditions['status'] = array('$ne' => 'not_active');

        $rootCat = Categories::first(array('conditions'=>array('parent_id'=>null)));
        $categories = $rootCat->nestedChildrens(true);

		$order = array('created'=>'desc');
		$limit = 24;
		$page = $this->request->page;
		$total = Products::count(compact('order','conditions'));
		$products = Products::all(compact('order','conditions', 'limit', 'page'));
        

        // $products = Products::all();
        // foreach ($products as $key => $product) {
        //     // $catId = new MongoId($product->category_id);
        //     // $product->category_id2 = $catId;
        //     $desc = $product->description();
        //     // unset($product->description);
        //     $product->description = $desc;
        //     $product->save();
        // }

        return compact('products', 'categories', 'page', 'total', 'limit');
	}

	public function search() {
		$query = $this->request->data['query'];


		$conditions = array('title' => array('like' => '/'.$query.'/i'));
		$categories = Categories::all(array('order'=>array('title'=>'asc')));
		$order = array('position'=>'asc');
		$products = Products::all(compact('order','conditions'));
		$this->_render['template'] = 'index';
        return compact('products', 'categories');	
	}

	public function add() {
        extract(Message::aliases());

        $rootCat = Categories::first(array('conditions'=>array('parent_id'=>null)));
        $categories = $rootCat->nestedChildrens(true);
        $channels = Channels::getListByType('product');

        $collections = Pages::find('list', ['conditions'=>[ 'channel_id'=> '54f5a092e72349cc0cb7acd9']]);
        $this->_breadcrumbs[$t('New product')] = array('Products::add');
		$product = Products::create();
		if ($this->request->data && $product->save($this->request->data)) {
			$this->redirect(array('Products::edit', 'id' => $product->_id));
		}
		return compact('product', 'channels', 'categories', 'rootCat', 'collections');
	}


	public function edit() {
        extract(Message::aliases());


        $rootCat = Categories::first(array('conditions'=>array('parent_id'=>null)));
        $categories = $rootCat->nestedChildrens(true);

        $channels = Channels::getListByType('product');
		$product = Products::find($this->request->id);
        $this->_breadcrumbs[$t('Products')] = array('Products::index');
        $this->_breadcrumbs[$product->title] = $this->request->params;
		if (!$product) {
			return $this->redirect('Products::index');
		}
        
        $collections = Pages::find('list', ['conditions'=>[ 'channel_id'=> '54f5a092e72349cc0cb7acd9']]);

		$media = Media::find('all', array(
			'conditions'=>array('fk_id'=>(string)$product->_id, 'fk_type'=>'products'),
			'order' => 'position'
		));
		if ($this->request->data) {
			$product->save($this->request->data);
		}		

        if (!empty($product->channel_id)) {

            $channel = Channels::find($product->channel_id);
            $channel->schema = json_decode($channel->schema);
        }

		return compact('product', 'media', 'channels', 'channel', 'categories', 'rootCat', 'collections');
	}


    public function inventory() {

        if (count($this->request->params['args'])) {
            $slug = $this->request->params['args'][0];
            $category = Categories::find('first', array('conditions'=>array('slug'=>$slug)));
            $conditions['category_id'] = (string)$category->_id;            
        }

        $this->_breadcrumbs['Products'] = array('Products::index');
        $order = array('created'=>'asc');
        $products = Products::all(compact('order', 'conditions'));
        return compact('products');

    }


    public function getChannelForm() {
        $productId = $this->request->data['productId'];
        $channelId = $this->request->data['channelId'];
        

        $this->_render['layout'] = false;
        $this->_render['template'] = 'element_channel';
        

        if (!empty($channelId)) {
            $channel = Channels::find($channelId);
            $channel->schema = json_decode($channel->schema);            
        } else {
            $channel = Channels::create();
        }



        
        if (!is_null($productId)) {
            $product = Products::find($productId);
        } else {
            $product = Products::create();
        }

        return compact('product', 'channel');


    }

    public function getChannelVariants() {
        $productId = $this->request->data['productId'];
        $channelId = $this->request->data['channelId'];
        

        $this->_render['layout'] = false;
        $this->_render['template'] = 'element_inventory';


        if (!empty($channelId)) {
            $channel = Channels::find($channelId);
            $channel->schema = json_decode($channel->schema);            
        } else {
            $channel = Channels::create();
        }

        if (!is_null($productId)) {
            $product = Products::find($productId);
        } else {
            $product = Products::create();
        }

        return compact('product', 'channel');


    }

    
    public function setfield() {

        $aKey = explode('_', $this->request->data['key']);
        $value = $this->request->data['value'];
        
        $content = Products::find($aKey[1]);
        if ($content) {
            $content->{$aKey[0]} = $value;
            $content->save();
        }
        return compact("content");
    }   



	public function delete() {
		$product  = Products::rm($this->request->id);
		return $this->redirect($this->request->referer());
	}


// 	public function importasdasdsa() {


// 		ini_set('auto_detect_line_endings', true);

//         $handle = fopen(LITHIUM_APP_PATH."/resources/shopify.csv", "r");
//         $fields = fgetcsv($handle, 0, ',');

// $descriptions = array( 
//     'SANTOKU' => '<p>Santoku se traduit littéralement par « trois fonctions » : émincer, hacher et couper en dés. Sa large lame s’adapte en toute sécurité aux techniques de coupe rapides : les articulations des doigts doivent en effet rester en contact avec le côté de la lame alors que les doigts sont rentrés vers l’intérieur, à l’abri du tranchant. Le santoku est un couteau polyvalent qui convient très bien à la découpe de tout type de chair crue, mais son profil relativement droit et sa large lame font de lui l’un des meilleurs couteaux pour la préparation des légumes. Sa lame de 18 cm est adaptée au hachage et à tout type de découpe nécessitant une certaine longueur. Ce couteau parfaitement équilibré se prête à une très grande variété de tâches.</p>
// <p><strong>REMARQUES IMPORTANTES</strong> : Ne pas utiliser sur les os. Ne doit pas servir de levier. Ne doit pas être utilisé pour bricoler. Utiliser UNIQUEMENT sur une planche à découper en bois ou en plastique. Ne pas utiliser les couteaux comme tournevis, ouvre-boîtes ou tout usage autre que la préparation des aliments. USAGE CULINAIRE UNIQUEMENT.</p>',

//     'PARING' => '<p>Ce couteau d’office est polyvalent, il convient aux tâches de tous les jours. Il a été étudié pour un usage dans la main et son extrémité en pointe permet par exemple d’enlever facilement les yeux des pommes de terre. Cette lame conviendra parfaitement à tous ceux qui sont plus à l’aise avec les petits couteaux. Pour les professionnels et les cuisiniers chevronnés, c’est l’outil idéal pour éplucher, peler ou faire des entailles dans une pâte. <br>
// Ce petit couteau polyvalent convient aux petites tâches de tous les jours. C’est le couteau le plus répandu dans les cuisines domestiques. Son extrémité en pointe permet par exemple d’enlever très facilement les yeux des pommes de terre. Sa lame est par ailleurs assez longue pour toutes sortes de tâches telles qu’émincer, éplucher ou couper des légumes en dés. Ce couteau est conçu aussi bien pour un usage dans la main que sur une planche à découper. Il conviendra parfaitement à tous ceux qui sont plus à l’aise avec les petits couteaux. Pour les professionnels et les cuisiniers chevronnés, c’est l’outil idéal pour éplucher, peler ou faire des entailles dans une pâte. </p>
// <p><strong>REMARQUES IMPORTANTES</strong> : Ne pas utiliser sur les os. Ne doit pas servir de levier. Ne doit pas être utilisé pour bricoler. Utiliser UNIQUEMENT sur une planche à découper en bois ou en plastique. Ne pas utiliser les couteaux comme tournevis, ouvre-boîtes ou tout usage autre que la préparation des aliments. USAGE CULINAIRE UNIQUEMENT.</p>',

//     'NAKIRI' => '<p>Ce style de couteau est appelé nakiri qui se traduit par « tranchant très fin ». Il s’agit essentiellement d’une version à double tranchant du style usuba. Bien qu’il puisse ressembler à un couperet, il s’agit en fait d’un outil d’une grande précision conçu pour de nombreuses utilisations telles que ciseler des oignons ou transformer de la ciboulette en poudre. Le nakiri est très apprécié des chefs occidentaux car il permet de réaliser une grande variété de tâches, des rondelles de tomates aux tranches de concombre translucides.
// C’est le type de couteau qu’il vous faut si vous préparez des légumes régulièrement. Avec un peu de pratique, vous saisirez que les capacités de ce type de couteau sont sans égales. Sa large lame est particulièrement efficace sur les aliments ayant de nombreuses strates comme les oignons ou les choux.</p>
// <p><strong>REMARQUES IMPORTANTES</strong> : Ne pas utiliser sur les os. Ne doit pas servir de levier. Ne doit pas être utilisé pour bricoler. Utiliser UNIQUEMENT sur une planche à découper en bois ou en plastique. Ne pas utiliser les couteaux comme tournevis, ouvre-boîtes ou tout usage autre que la préparation des aliments. USAGE CULINAIRE UNIQUEMENT.',

//     'SUJIHIKI' => '<p>Le sujihiki est un couteau long et fin conçu pour découper avec une grande facilité toutes les chairs, crues comme cuites (viande, volaille, gibier, poisson). Grâce à sa surface réduite, même les chairs les plus grasses ne restent pas collées à la lame. Ce couteau vous apportera une grande satisfaction à transformer des tâches complexes, telles que couper de très fines tranches de carpaccio, découper un rôti ou partager de belles portions de poisson ou de viande, en véritables plaisirs des arts de la table.</p>
// <p><strong>REMARQUES IMPORTANTES</strong> : Ne pas utiliser sur les os. Ne doit pas servir de levier. Ne doit pas être utilisé pour bricoler. Utiliser UNIQUEMENT sur une planche à découper en bois ou en plastique. Ne pas utiliser les couteaux comme tournevis, ouvre-boîtes, etc. Conçu spécifiquement pour la préparation des aliments. USAGE CULINAIRE UNIQUEMENT.</p>',

//     'GYUTO' => '<p>Ce couteau, plus mince que son homologue le santoku, est appelé gyuto et est utilisé généralement pour la viande. En effet « gyu » se traduit littéralement par vache et « to » par lame. Il est conçu pour couper la viande ou le poisson cru aussi bien en tranches qu’en dés ou en filets. Il s’agit de la version japonaise du classique couteau de chef français. Ce couteau à l’apparence familière est un exemple de polyvalence avec sa forme fuselée, idéale pour tous types de coupes et de découpes. La lame recourbée permet aussi de couper les légumes avec une plus grande fluidité que la plupart des autres gyuto. La différence principale entre le santoku et le gyuto réside dans la largeur de la lame. Celle du gyuto est plus étroite ce qui lui permet d’être plus efficace face aux aliments gras, riches en amidon, huileux ou tout autre aliment ayant tendance à rester collé à la lame. Si vous recherchez un couteau essentiellement pour la viande ou le poisson, cru comme cuit, et accessoirement pour les légumes, le gyuto est celui qu’il vous faut. Il conviendra également à ceux qui préfèrent les formes de couteaux occidentales plus classiques.</p>
// <p><strong>REMARQUES IMPORTANTES</strong> : Ne pas utiliser sur les os. Ne doit pas servir de levier. Ne doit pas être utilisé pour bricoler. Utiliser UNIQUEMENT sur une planche à découper en bois ou en plastique. Ne pas utiliser les couteaux comme tournevis, ouvre-boîtes ou tout usage autre que la préparation des aliments.  USAGE CULINAIRE UNIQUEMENT.',

//     'BONING' => '<p>Le couteau à désosser de 16 cm fait partie des couteaux les plus courants dans les cuisines domestiques occidentales. Ceux qui ne sont pas tout à fait à l’aise avec les couteaux larges le trouveront beaucoup plus maniable. Sa longueur de lame permet de préparer facilement tout type d’aliment. Son profil très fin est également approprié par exemple à la découpe d’un rôti ou à la levée de filets. C’est aussi un couteau très tranchant, idéal pour préparer le poisson ou le gibier ainsi que pour le dépouiller ou le désosser.</p>
// <p><strong>REMARQUES IMPORTANTES</strong> : Ne pas utiliser sur les os. Ne doit pas servir de levier. Ne doit pas être utilisé pour bricoler. Utiliser UNIQUEMENT sur une planche à découper en bois ou en plastique. Ne pas utiliser les couteaux comme tournevis, ouvre-boîtes, etc. Conçu spécifiquement pour la préparation des aliments. USAGE CULINAIRE UNIQUEMENT</p>',

//     'BREAD' => '<p>Le couteau à pain est bien évidemment idéal pour couper toutes sortes de pains et de croûtes, mais il peut s’avérer aussi être très utile pour les gâteaux d’anniversaire par exemple.</p>',

//     'UTILITY' => '<p>Le couteau universel de 15 cm fait partie des couteaux les plus utilisés dans les cuisines domestiques occidentales. Ceux qui ne sont pas tout à fait à l’aise avec les couteaux plus larges le trouveront beaucoup plus maniable. Comme son nom l’indique, sa longueur permet la préparation de tout type d’aliment. Grâce à son profil assez fin, il peut également servir à découper un rôti ou encore à lever des filets. C’est aussi un couteau très tranchant, idéal pour préparer le poisson ou le gibier ainsi que pour le dépouiller ou le désosser.<br>
// Remarquablement élégants, tranchants et faciles à réaffûter, ces couteaux inoxydables sont très faciles à entretenir.</p>
// <p><strong>REMARQUES IMPORTANTES</strong> : Ne pas utiliser sur les os. Ne doit pas servir de levier. Ne doit pas être utilisé pour bricoler. Utiliser UNIQUEMENT sur une planche à découper en bois ou en plastique. Ne pas utiliser les couteaux comme tournevis, ouvre-boîtes ou tout usage autre que la préparation des aliments.  USAGE CULINAIRE UNIQUEMENT.</p>',

//     'YANAGIBA' =>  '<p>Yanagiba se traduit par « feuille de saule ». C’est la forme de couteau la plus répandue dans les restaurants de sushis du monde entier. Ce couteau asymétrique typiquement japonais est inégalé dans l’art de couper les tranches les plus fines qui soient. Généralement utilisé pour lever des filets de poisson, il est également idéal pour la découpe de très fines tranches de viande. Ce couteau japonais traditionnel est biseauté : il est conçu pour ne pas altérer les aliments que l’on coupe, même en très fines tranches.<br>
// Le modèle 15315 possède une lame de 30 cm, idéale si vous aimez les couteaux particulièrement longs… C’est la taille d’une petite épée de samouraï. Ce couteau effectuera sans aucun effort les tâches les plus exigeantes. Vous ne trouverez pas de meilleur outil pour la préparation des sushis ou des sashimis. Les feuilles d’algues les plus craquantes se laisseront découper avec une grande finesse, et les poissons les plus délicats ne verront pas leur chair altérée par la lame. Même les aliments les plus difficiles à couper n’opposeront aucune résistance à sa lame. Notez que cette longueur de lame n’est conseillée qu’aux personnes à l’aise avec les couteaux particulièrement grands.</p>',

//     'DEBA' =>  '<p>Deba peut se traduire par « petit et gros » ! Ce couteau, très lourd, est conçu pour lever très proprement les filets de poisson sans altérer la nature de la chair. Son poids ainsi que la largeur du dos de sa lame en font un outil idéal pour casser les carapaces de crabes et autres crustacés de même que pour attendrir la viande. Pour toutes les tâches de hachage, il s’agit également de l’un des couteaux japonais les plus efficaces.<br>
// Le modèle 15351 possède une lame de 15 cm. Cette lame relativement courte conviendra parfaitement à ceux qui aiment avoir un certain poids dans la main sans pour autant être encombrés d’une lame trop longue. Sa lame très épaisse coupera sans aucun effort tout type d’aliment sans jamais altérer la chair des poissons les plus délicats.<br>
// Veuillez noter que lors de l’utilisation de ce couteau biseauté, la lame dévie au fur et à mesure de la découpe. Il est par conséquent conseillé de n’en faire l’acquisition que si l’on est capable d’en maîtriser le poids et le tranchant si particuliers.</p>',

//     'USUBA' =>  '<p>Ce style de couteau se nomme usuba. Les heureux propriétaires de ce couteau japonais traditionnel savent déjà tout, ou presque, de cette lame spécialement conçue pour les fruits et légumes. Comme tous les modèles de la collection New Tradition, il s’agit d’un couteau biseauté, il faut donc un peu de temps pour s’y accoutumer et pour pouvoir utiliser pleinement tout son potentiel.
// Si vous préparez des légumes régulièrement, des rondelles de tomates aux tranches de concombres translucides, c’est le type de couteau qu’il vous faut. Avec un peu de pratique, vous saisirez que ce style de couteau est véritablement sans égal. La largeur de sa lame lui permet de s’adapter parfaitement à toutes les techniques de coupe. Hacher des herbes, par exemple, deviendra un véritable plaisir !<br>
// Le modèle 15361WS possède une lame de 16,5 cm. Cette longueur de lame est  idéale pour hacher, émincer ou couper en dés. Son profil aplati permet également de très facilement ramasser les aliments coupés et de les déposer directement dans une poêle ou une casserole. Grâce à sa lame est extrêmement tranchante (acier au carbone très résistant recouvert d’une couche d’acier inoxydable plus malléable), ce couteau s’attaquera à la plupart des tâches avec une facilité déconcertante. Aux côtés de couteaux comme le kodeba, le kaisaki ou le santoku, c’est l’un des couteaux préférés des foyers et des chefs japonais.</p>',

//     'KODEBA' =>  '<p>Le kodeba est une version plus mince du deba, mais aussi plus délicate et plus facile à manipuler. Il convient à la plupart des tâches nécessitant un petit couteau. Comme tous les modèles de la collection New Tradition, c’est un couteau biseauté. Plus fin que le deba (environ 3 mm), il est plus facile à manier car la lame ne dévie pas lors de la découpe. Elle s’avère en effet beaucoup plus facile à contrôler par ceux qui ne maitrisent pas tout à fait les techniques d’utilisation de couteaux à un seul tranchant.<br>
// Le modèle 15331WS possède une lame de 12 cm. Cette lame relativement courte est idéale pour éplucher ou peler fruits et légumes. Elle est cependant assez large pour ne pas se limiter aux tâches généralement réservées aux petits couteaux. Celui-ci s’adapte en effet parfaitement aux différentes techniques de coupes utilisées pour les fruits et légumes ou pour hacher des herbes, contrairement aux couteaux plus minces pour lesquels les mouvements de va-et-vient représentent un plus grand risque de se couper. Grâce à sa lame extrêmement tranchante (acier au carbone très résistant recouvert d’une couche d’acier inoxydable plus malléable), ce couteau s’attaquera à la plupart des tâches avec une facilité déconcertante. Aux côtés de couteaux comme le kaisaki, le usuba ou le santoku, c’est l’un des couteaux préférés des foyers et des chefs japonais.</p>',

//     'KAISAKI' =>  '<p>Le kaisaki est une version plus courte du yanagiba. Il convient à la plupart des tâches nécessitant un petit couteau. Comme tous les modèles de la collection New Tradition, c’est un couteau biseauté, mais étant plus court qu’un yanagiba, il est plus facile à utiliser.<br>
// Le modèle 15340WS possède une lame de 12 cm. Cette lame relativement courte est idéale pour éplucher ou peler fruits et légumes. Apprécié de ceux qui sont plus à l’aise avec les petits couteaux, il est cependant assez long pour effectuer la plupart des tâches quotidiennes de découpe. Grâce à sa lame extrêmement tranchante, (acier au carbone très résistant recouvert d’une couche d’acier inoxydable plus malléable), ce couteau s’attaquera à la plupart des tâches avec facilité. Aux côtés de couteaux comme le kodeba, le usuba ou le santoku, c’est l’un des couteaux préférés des foyers japonais.</p>'
// );




//     $translation = array(
//         'Blade Length'=> 'Longueur de lame',
//         'Total Length'=> 'Longueur totale',
//         'Thickness'=> 'Epaisseur',
//         'Total Weight'=> 'Poid total',
//         'Core steel'=> 'Acier lame',
//         // 'Laminate steel'=> '',
//         'Rockwell'=> 'Dureté',
//         'Layers'=> 'Couches',
//         'Handle'=> 'Manche',
//         'Country of Origin'=> "Pays d'origine"
//     );

    

//     $translation2 = array(
//         'boning'=> ' - Couteau à désosser',
//         'bread'=> ' - Couteau à pain',
//         'paring'=> " - Couteau d'office",
//         'utility'=> " - Couteau universel",
//         'SANTOKU' => 'Santoku',
//         'NAKIRI' => 'Nakiri',
//         'SUJIHIKI' => 'Sujihiki',
//         'GYUTO' => 'Gyuto',
//         'YANAGIBA' => 'Yanagiba',
//         'DEBA' => 'Deba',
//         'USUBA' => 'Usuba',
//         'KODEBA' => 'Kodeba',
//         'KAISAKI' => 'Kaisaki'
//     );




// 		// $handle = fopen(LITHIUM_APP_PATH."/resources/products.csv", "r");
// 		// $fields = fgetcsv($handle, 0, ',');
// 		// $fields = array_map('strtolower', $fields);
// 		// echo "<pre>";
// 		// $i = 1;

//         try {
//             $dbh = new \PDO('mysql:dbname=jkc2;host=localhost;port=3306', 'root', '', array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
//         }
//         catch(\PDOException $e) {
//             echo $e->getMessage();
//         }
//         $dbh->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );
//         $query = $dbh->query('SELECT nid, field_heading_value FROM content_field_heading');
//         $brands = $query->fetchAll(\PDO::FETCH_KEY_PAIR);



//         $variationsId = array();
//         foreach ($fields as $key => $field) {
//             if (strpos($field,"attributes['17']->options") !== false) {
//                 if(preg_match_all('/\d+/', $field, $numbers)) {
//                     $lastnum = end($numbers[0]);
//                     if(!in_array($lastnum, $variationsId, true)){
//                         array_push($variationsId, $lastnum);
//                     }

//                 }
//             }
//         }

//         // print_r($variationsId);

//         $collections = array(
//             148 => '54f446dbe723497a04b7acd9',
//             149 => '54f446e6e723495704b7acda',
//             147 => '54f446f1e723495704b7acdb',
//             150 => '54f446ffe723495704b7acdc',
//             147148 => '54f446f1e723495704b7acdb',
//             147148149150  => '54f446dbe723497a04b7acd9',
//             ''  => '54f446dbe723497a04b7acd9'
//         );




//         while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {

//             $data = array_combine($fields, $data);

//             if (strpos($data['path'],'products') !== false) {
//                 $product = Products::create();
//                 $path = explode('/',$data['path']);
//                 $slug = end($path);

//                 $collection = $data["taxonomy['6']['147']"] . $data["taxonomy['6']['148']"]  . $data["taxonomy['6']['149']"]  .  $data["taxonomy['6']['150']"];
                

//                 $technical = $data["field_technical_information['0']['value']"];
//                 $technical = strip_tags($technical, '<strong>');
//                 $technical = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $technical);

//                 $patterns = array_keys($translation);
//                 $replacements = array_values($translation);

                
//                 $technical = str_ireplace('<strong>','</li><li><strong>', $technical);
//                 $technical = str_ireplace($patterns,$replacements,$technical);
//                 $technical = preg_replace('/<\/li>/', '<ul>', $technical, 1); // outputs '123def abcdef abcdef'
//                 $technical = str_ireplace('<li><strong></li>','', $technical);
//                 $technical = "{$technical}</ul>";
                


//                 $title = $data['title'];
                
//                 $description = $data['body'];
//                 $status = 'draft';
//                 foreach ($descriptions as $key => $desc) {
//                     if (stripos($title, $key) !== FALSE) { // Yoshi version
//                         // echo "Match found"; 
//                         $description = $desc;
//                         $patterns = array_keys($translation2);
//                         $replacements = array_values($translation2);                
//                         $title = str_ireplace($patterns,$replacements,$title);
//                         $status = 'published';
//                     } 
//                 }

//                 $title = str_ireplace('(Available in ','(disponible en', $title);
//                 $title = str_ireplace(' sizes)',' tailles)', $title);


//                 $type = array_keys($descriptions);
//                 // if ($pos = strpos($mystring, $findme))





//                 $vendor = ($data["field_product_brand['0']['nid']"] != 'NULL' && isset($brands[$data["field_product_brand['0']['nid']"]])) ? $brands[$data["field_product_brand['0']['nid']"]]:'';
// if ($technical == 'NULL') {
//     $technical = '';
// }


// $cleaning = $data["field_product_d_cleaning['0']['value']"];
// if ($cleaning !== 'NULL') {
//     $cleaning = '<strong>Ne pas metter au lave vaisselle.</strong> Lavage à la main avec un détergent doux. <strong>Sécher immédiatement.</strong>';
// } else {
//     $cleaning = '';
// }


// echo '<p>';
//     echo '<h3>' . $title . '</h3>';
//     echo $cleaning ;
// echo '</p>';



            
//                 $price = number_format($data['sell_price'], 2, '.', '');
//                 $price = ceil($price * 1.3635);


//                 $aProduct = array(
//                     'title' => $title,

//                     'quantity' => 1,
//                     'channel_id' => '54f43687e723496603b7acd9',

//                     'price' => $price,
//                     'in_stock' => true,
//                     'sku' =>  $data['model'],
                    
//                     'description' => $description,
//                     'category_id' => $collections[$collection],
//                     'vendor' => $vendor,
//                     'slug' => $slug,
//                     'status' => $status, 

//                     'channel.technical' => $technical,
//                     'channel.cleaning' => $cleaning

//                 );



//                 $variations = array();

//                 foreach ($variationsId as $key => $id) {
//                     if ($data["attributes['17']->options['{$id}']->nid"] !== '') {

//                         $price = number_format($data['sell_price'] + $data["attributes['17']->options['{$id}']->price"], 2, '.', '');

//                         $variations[] = array(
//                             'size' => $data["attributes['17']->options['{$id}']->name"],
//                             'price' => $price,
//                             'sku' => $data['model'] . '-' . $data["attributes['17']->options['{$id}']->name"],
//                             'quantity' => 1
//                         );
//                     }
//                 }

//                 if (count($variations)) {
//                     $aProduct['variants'] = $variations;
//                 }
//                 // if (count($variations)>1) {
//                     $product->save($aProduct);
//                 // }

//                 $pos = 0;
//                 for($i = 0; $i <= 8; $i++ ) {
//                     if ($data["field_image_cache['{$i}']['filepath']"] !== '') {

//                         $file = 'http://www.japaneseknifecompany.com/'.$data["field_image_cache['{$i}']['filepath']"];
//                         $file = str_replace(' ', '%20', $file);

//                         $media = Media::create();
//                         $mData = $media->upload($file);
//                         $mData['fk_id'] = (string)$product->_id;
//                         $mData['fk_type'] = 'products';
//                         $mData['position'] = $pos++;
//                         $media->save($mData);

//                     }
//                 }


//             }

// 	   }

//     }




//     public function import() {
//         ini_set('auto_detect_line_endings', true);

//         $handle = fopen(LITHIUM_APP_PATH."/resources/tools.csv", "r");
//         $fields = fgetcsv($handle, 0, ',');

// echo '<pre>';


//         // $handle = fopen(LITHIUM_APP_PATH."/resources/products.csv", "r");
//         // $fields = fgetcsv($handle, 0, ',');
//         // $fields = array_map('strtolower', $fields);
//         // echo "<pre>";
//         // $i = 1;

//         try {
//             $dbh = new \PDO('mysql:dbname=jkc2;host=localhost;port=3306', 'root', '', array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
//         }
//         catch(\PDOException $e) {
//             echo $e->getMessage();
//         }
//         $dbh->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );
//         $query = $dbh->query('SELECT nid, field_heading_value FROM content_field_heading');
//         $brands = $query->fetchAll(\PDO::FETCH_KEY_PAIR);



//         $variationsId = array();
//         foreach ($fields as $key => $field) {
//             if (strpos($field,"attributes['17']->options") !== false) {
//                 if(preg_match_all('/\d+/', $field, $numbers)) {
//                     $lastnum = end($numbers[0]);
//                     if(!in_array($lastnum, $variationsId, true)){
//                         array_push($variationsId, $lastnum);
//                     }

//                 }
//             }
//         }

//         // print_r($variationsId);
//         // affutage //
//         // $collections = array(            
//         //     154 => '54f4475ae723495604b7acd9',
//         //     153 => '54f4474ee723496504b7acda',
//         //     288 => '54f447a7e723492a04b7acd9',
//         //     155 => '54f447d4e723492a04b7acda',
//         //     ''  => '54f4474ee723496504b7acda'
//         // );


//         // Rangement //
//         // $collections = array(            
//         //     241 => '54f447e9e723492a04b7acdb',
//         //     243 => '54f447ffe723492a04b7acdc',
//         //     287 => '54f44818e723495a04b7acd9',
//         //     ''  => ''
//         // );


//         // Accessories //
//         // $collections = array(            
//         //     284 => '54f44824e72349d203b7acda',
//         //     285 => '54f44824e72349d203b7acda',
//         //     289 => '54f44833e72349d203b7acdb',
//         //     290 => '54f44840e72349d203b7acdc',
//         //     292 => '54f44840e72349d203b7acdc',
//         //     293 => '552089df53692ee207b7acd9',
//         //     ''  => '54f446b6e723493e04b7acdc'
//         // );


//         $collections = array(            
//             265 => '54f44863e723495804b7acd9',
//             267 => '54f4484fe723497c04b7acd9',
//             ''  => ''
//         );



//         while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {

//             $data = array_combine($fields, $data);

//             if (strpos($data['path'],'products') !== false) {
//                 $product = Products::create();
//                 $path = explode('/',$data['path']);
//                 $slug = end($path);


//                 // affutage //
//                 // $collection = isset($data["taxonomy['6']['155']"])?$data["taxonomy['6']['155']"]:'';
//                 // $collection .= isset($data["taxonomy['6']['288']"])?$data["taxonomy['6']['288']"]:'';
//                 // $collection .= isset($data["taxonomy['6']['153']"])?$data["taxonomy['6']['153']"]:'';
//                 // $collection .= isset($data["taxonomy['6']['154']"])?$data["taxonomy['6']['154']"]:'';
                


//                 // // Rangement //
//                 $collection = isset($data["taxonomy['6']['241']"])?$data["taxonomy['6']['241']"]:'';
//                 $collection .= isset($data["taxonomy['6']['243']"])?$data["taxonomy['6']['243']"]:'';
//                 $collection .= isset($data["taxonomy['6']['287']"])?$data["taxonomy['6']['287']"]:'';


//                 // Accessoires //
//                 // $collection = isset($data["taxonomy['6']['284']"])?$data["taxonomy['6']['284']"]:'';
//                 // $collection .= isset($data["taxonomy['6']['285']"])?$data["taxonomy['6']['285']"]:'';
//                 // $collection .= isset($data["taxonomy['6']['289']"])?$data["taxonomy['6']['289']"]:'';
//                 // $collection .= isset($data["taxonomy['6']['290']"])?$data["taxonomy['6']['290']"]:'';
//                 // $collection .= isset($data["taxonomy['6']['292']"])?$data["taxonomy['6']['292']"]:'';
//                 // $collection .= isset($data["taxonomy['6']['293']"])?$data["taxonomy['6']['293']"]:'';


//                 echo $collection;

//                 $title = $data['title'];                
//                 $description = $data['body'];
//                 $description = preg_replace('/(<[^>]+) class=".*?"/i', '$1', $description);
//                 $description = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $description);
//                 // $pattern = "/<p[^>]*><\\/p[^>]*>/"; 
//                 $pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/"; 
//                 $description = preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>/", '', $description);
//                 $description = preg_replace($pattern, '', $description); 

//                 $description = preg_replace('/<p>\s*(<a .*>)\s*(<\/a>)?\s*<\/p>/iU', '', $description);
//                 $description = preg_replace('/<h[1-6]>(.*?)<\/h[1-6]>/', '<p>$1</p>', $description);
//                 $description = str_replace('<strong><strong>', '<strong>', $description);
//                 $description = str_replace('<strong><span><strong>', '<span><strong>', $description);


//                 $status = 'draft';

//                 $vendor = ($data["field_product_brand['0']['nid']"] != 'NULL' && isset($brands[$data["field_product_brand['0']['nid']"]])) ? $brands[$data["field_product_brand['0']['nid']"]]:'';


//                     echo '<h3>' . $title . '</h3>';
//                     echo $vendor ;
            
//                 $price = number_format($data['sell_price'], 2, '.', '');
//                 $price = ceil($price * 1.3635);
//                 $price = number_format($price, 2, '.', '');

// if ($collections[$collection] == '') {
//     print_r($data);
// }

//                 $aProduct = array(
//                     'title' => $title,

//                     'quantity' => 1,
//                     'channel_id' => '5520750853692e1d07b7acd9',

//                     'price' => $price,
//                     'in_stock' => true,
//                     'sku' =>  $data['model'],
                    
//                     'description' => $description,
//                     'category_id' => $collections[$collection],
//                     'vendor' => $vendor,
//                     'slug' => $slug,
//                     'status' => $status
//                 );

//                 print_r($aProduct);

//                 // $variations = array();

//                 // foreach ($variationsId as $key => $id) {
//                 //     if ($data["attributes['17']->options['{$id}']->nid"] !== '') {

//                 //         $price = number_format($data['sell_price'] + $data["attributes['17']->options['{$id}']->price"], 2, '.', '');

//                 //         $variations[] = array(
//                 //             'size' => $data["attributes['17']->options['{$id}']->name"],
//                 //             'price' => $price,
//                 //             'sku' => $data['model'] . '-' . $data["attributes['17']->options['{$id}']->name"],
//                 //             'quantity' => 1
//                 //         );
//                 //     }
//                 // }

//                 // if (count($variations)) {
//                 //     $aProduct['variants'] = $variations;
//                 // }
//                 // if (count($variations)>1) {
//                     $product->save($aProduct);
//                 // }

//                 $pos = 0;
//                 for($i = 0; $i <= 8; $i++ ) {
//                     if (isset($data["field_image_cache['{$i}']['filepath']"]) && $data["field_image_cache['{$i}']['filepath']"] !== '') {

//                         $file = 'http://www.japaneseknifecompany.com/'.$data["field_image_cache['{$i}']['filepath']"];
//                         $file = str_replace(' ', '%20', $file);

//                         $media = Media::create();
//                         $mData = $media->upload($file);
//                         $mData['fk_id'] = (string)$product->_id;
//                         $mData['fk_type'] = 'products';
//                         $mData['position'] = $pos++;
//                         $media->save($mData);

//                     }
//                 }


//             }

//        }

//     }








}


?>