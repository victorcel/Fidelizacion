<?php namespace App\Http\Controllers;

	use Mike42\Escpos\EscposImage;
    use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
    use Mike42\Escpos\Printer;
    use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminClientesController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = true;
			$this->table = "clientes";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Cedula","name"=>"cedula"];
			$this->col[] = ["label"=>"Nombres","name"=>"Nombres"];
			$this->col[] = ["label"=>"Apellidos","name"=>"apellidos"];
			$this->col[] = ["label"=>"Direccion","name"=>"direccion"];
			$this->col[] = ["label"=>"Telefono","name"=>"telefono"];
			$this->col[] = ["label"=>"Fecha Nacimiento","name"=>"fechaNacimiento"];
			$this->col[] = ["label"=>"Departamento Id","name"=>"departamento_id","join"=>"departamentos,departamento"];
			$this->col[] = ["label"=>"Municipio Id","name"=>"municipio_id","join"=>"municipios,municipio"];
			$this->col[] = ["label"=>"Corregimientos","name"=>"corregimientos"];
			$this->col[] = ["label"=>"Observacion","name"=>"observacion"];
			$this->col[] = ["label"=>"Fecha Creacion","name"=>"created_at"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Cedula','name'=>'cedula','type'=>'number','validation'=>'required|integer|min:0|unique:clientes','width'=>'col-sm-5'];
			$this->form[] = ['label'=>'Nombres','name'=>'Nombres','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-5'];
			$this->form[] = ['label'=>'Apellidos','name'=>'apellidos','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-5'];
			$this->form[] = ['label'=>'Direccion','name'=>'direccion','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-5'];
			$this->form[] = ['label'=>'Telefono','name'=>'telefono','type'=>'number','validation'=>'required|min:1|unique:clientes','width'=>'col-sm-5'];
			$this->form[] = ['label'=>'Fecha Nacimiento','name'=>'fechaNacimiento','type'=>'date','validation'=>'required|min:1','width'=>'col-sm-5'];
			$this->form[] = ['label'=>'Departamento','name'=>'departamento_id','type'=>'select2','validation'=>'required|integer|min:1','width'=>'col-sm-5','datatable'=>'departamentos,departamento'];
			$this->form[] = ['label'=>'Municipio','name'=>'municipio_id','type'=>'select','validation'=>'required|integer|min:1','width'=>'col-sm-5','datatable'=>'municipios,municipio','dataquery'=>'SELECT * FROM `municipios`  ORDER by id','parent_select'=>'departamento_id'];
			$this->form[] = ['label'=>'Corregimientos','name'=>'corregimientos','type'=>'text','validation'=>'required','width'=>'col-sm-5'];
			$this->form[] = ['label'=>'Observacion','name'=>'observacion','type'=>'textarea','validation'=>'min:1|max:255','width'=>'col-sm-5'];
			$this->form[] = ['label'=>'Email','name'=>'email','type'=>'email','validation'=>'required|min:1|max:255|email|unique:clientes','width'=>'col-sm-5'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Cedula','name'=>'cedula','type'=>'number','validation'=>'required|integer|min:0|unique:clientes','width'=>'col-sm-5'];
			//$this->form[] = ['label'=>'Nombres','name'=>'Nombres','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-5'];
			//$this->form[] = ['label'=>'Apellidos','name'=>'apellidos','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-5'];
			//$this->form[] = ['label'=>'Direccion','name'=>'direccion','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-5'];
			//$this->form[] = ['label'=>'Telefono','name'=>'telefono','type'=>'number','validation'=>'required|min:1|unique:clientes','width'=>'col-sm-5'];
			//$this->form[] = ['label'=>'Fecha Nacimiento','name'=>'fechaNacimiento','type'=>'date','validation'=>'required|min:1','width'=>'col-sm-5'];
			//$this->form[] = ['label'=>'Departamento','name'=>'departamento_id','type'=>'select2','validation'=>'required|integer|min:1','width'=>'col-sm-5','datatable'=>'departamentos,departamento'];
			//$this->form[] = ['label'=>'Municipio','name'=>'municipio_id','type'=>'select','validation'=>'required|integer|min:1','width'=>'col-sm-5','datatable'=>'municipios,municipio','dataquery'=>'SELECT * FROM `municipios`  ORDER by id','parent_select'=>'departamento_id'];
			//$this->form[] = ['label'=>'Corregimientos','name'=>'corregimientos','type'=>'text','validation'=>'required','width'=>'col-sm-9'];
			//$this->form[] = ['label'=>'Observacion','name'=>'observacion','type'=>'textarea','validation'=>'min:1|max:255','width'=>'col-sm-5'];
			//$this->form[] = ['label'=>'Email','name'=>'email','type'=>'email','validation'=>'required|min:1|max:255|email|unique:clientes','width'=>'col-sm-5'];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();
            $this->index_statistic[] = ['label'=>'Total De Usuarios','count'=>DB::table('clientes')->count(),'icon'=>'fa fa-users','color'=>'success'];


	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {


	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {
            $nombre_impresora = "smb://10.43.88.39/tg2480-h";

            $connector = new WindowsPrintConnector($nombre_impresora);
            $printer = new Printer($connector);

            /*
                Imprimimos un mensaje. Podemos usar
                el salto de línea o llamar muchas
                veces a $printer->text()
            */
            try{
                $logo = EscposImage::load("C:/laragon/www/fide/resources/views/sundreams1.png", false);
                $printer->bitImage($logo);
                $printer->feed(7);
                $logo = EscposImage::load("C:/laragon/www/fide/resources/views/sundreams1.png", false);
                $printer->bitImage($logo);
            }catch(Exception $e){/*No hacemos nada si hay error*/}

            /*
                Hacemos que el papel salga. Es como
                dejar muchos saltos de línea sin escribir nada
            */
            $printer->feed();

            /*
                Cortamos el papel. Si nuestra impresora
                no tiene soporte para ello, no generará
                ningún error
            */
            $printer->cut();

            /*
                Por medio de la impresora mandamos un pulso.
                Esto es útil cuando la tenemos conectada
                por ejemplo a un cajón
            */
            $printer->pulse();

            /*
                Para imprimir realmente, tenemos que "cerrar"
                la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
            */
            $printer->close();
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }



	    //By the way, you can still create your own method in here... :) 


	}