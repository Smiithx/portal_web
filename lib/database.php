<?php

class database{
    public $db;
    protected $resultado;
    protected $prep;
    protected $consulta;

    public function __construct($dbhots,$dbuser,$dbpass,$dbname){
        $this->db = new mysqli($dbhots,$dbuser,$dbpass,$dbname);
        if($this->db->connect_errno){
            trigger_error("fallo la conexión con MySQL, Tipo de error -> ({$this->db->connect_error})",E_USER_ERROR);
        }
        $this->db->set_charset("utf8");
    }
    public function getClientes(){
        $this->resultado = $this->db->query("SELECT * from clientes");
        $clientes = [];
        while($row =  $this->resultado->fetch_assoc()){
            $clientes[] = $row;
        }
        return $clientes;
    }
    public function getAssoc(){
        return $this->resultado->fetch_assoc();
    }
    public function preparar($consulta){
        $this->consulta = $consulta;
        $this->prep = $this->db->prepare($this->consulta);
        if(!$this->prep){
            return "Error al preparar la consulta";
        }else{
            return true;
        }
    }
    public function ejecutar(){
        $this->prep->execute();
    }
    public function prep(){
        return $this->prep;
    }
    public function resultado(){
        return $this->prep->fetch();
    }
    public function cambiarDatabase($db){
        $this->db->select_db($db);
    }
    public function validarDatos($columna,$tabla,$condicion){
        $this->resultado = $this->db->query("SELECT $columna FROM $tabla WHERE $columna = '$condicion'");
        $chequear = $this->resultado->num_rows;
        return $chequear;
    }
    public function cerrar(){
        $this->db->close();
        $this->prep->close();
    }
    public function liberar(){
        $this->prep->free_result();
    }
    public function filasAfectadas(){
        return $this->prep->affected_rows;
    }
}