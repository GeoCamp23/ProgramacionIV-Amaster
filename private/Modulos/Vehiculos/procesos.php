<?php
 
    include('../../Config/Config.php');

    $Vehiculos = new Vehiculos($conexion);

    $proceso = '';

    if ( isset( $_GET['proceso'] ) && strlen( $_GET['proceso'] ) > 0) {
        $proceso = $_GET['proceso'];
    }

    $Vehiculos->$proceso($_GET['Vehiculos']);
 
    print_r(json_encode($Vehiculos->respuesta));


    class Vehiculos{

        private $datos = array(), $db;
        public $respuesta = ['msg' => 'correcto'];

        public function __construct($db){

            $this->db = $db; 

        }

        public function recibirDatos($Vehiculos){

            $this->datos = json_decode($Vehiculos, true);
            $this->validar_datos();

        }

        private function validar_datos(){

            if ( empty( $this->datos['year']) ) {
                
                $this->respuesta['msg'] = 'Por favor ingrese el año del vehiculo';

            }

            if ( empty( $this->datos['modelo']) ) {
                
                $this->respuesta['msg'] = 'Por favor ingrese el modelo del vehiculo';

            }


            if ( empty( $this->datos['marca']) ) {
                
                $this->respuesta['msg'] = 'Por favor ingrese la marca del vehiculo';

            }

            if( $this->datos['accion'] == 'nuevo'){
                $this->almacenar_Vehiculos();
            }
            else{
                $this->modificarVehiculos();
            }


        }

        private function almacenar_Vehiculos(){

            if ( $this->respuesta['msg'] == 'correcto') {
                
                if ( $this->datos['accion'] === 'nuevo') {

                    $this->db->consultas('INSERT INTO tbl_vehiculos (marca, modelo, year) VALUES("'.$this->datos['marca'].'", "'.$this->datos['modelo'].'", "'.$this->datos['year'].'")');
                    $this->respuesta['msg'] = 'Registro ingresado correctamente';
                }

            }

        }
        
        public function buscarVehiculos($valor=''){
            $this->db->consultas('SELECT * FROM tbl_vehiculos WHERE (tbl_vehiculos.marca LIKE "%'.$valor.'%") OR (tbl_vehiculos.modelo LIKE "%'.$valor.'%") OR (tbl_vehiculos.year LIKE "%'.$valor.'%")');
            return $this->respuesta = $this->db->obtener_data();
        }

        public function eliminarVehiculos($idVehiculo=''){
            $this->db->consultas('DELETE FROM tbl_vehiculos WHERE IdVehiculo = '. $idVehiculo);
            $this->respuesta['msg'] = 'Registro eliminado correctamente';
        }

        public function modificarVehiculos(){

            if ( $this->respuesta['msg'] == 'correcto') {
                
                if ( $this->datos['accion'] === 'modificar') {

                    $this->db->consultas('UPDATE tbl_vehiculos SET marca = "'.$this->datos['marca'].'", modelo = "'.$this->datos['modelo'].'", year = "'.$this->datos['year'].'" WHERE idVehiculo  = '.$this->datos['idVehiculo']);

                    $this->respuesta['msg'] = 'Registro modificado correctamente';
                }
                
            }
        }

    }

?>