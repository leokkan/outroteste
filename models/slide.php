<?php
namespace Models;

use Lib\DB;
use Lib\Model;
/**
 * Modelo de um Slide
 */
class Slide extends Model{
    /**
     * ID do slide
     * @var integer
     */
	private $idSlide;
    /**
     * diretorio Imagem
     * @var string
     */
	private $imagem;
    /**
     * número de ordem
     * @var integer
     */
	private $ordem;

	public function __construct($idSlide, $imagem, $ordem) {
		$this->idSlide = $idSlide;
		$this->imagem = $imagem;
		$this->ordem = $ordem;
	}

    /**
     * Retorna um slide a partir de seu id
     * @param integer $idSlide ID do Slide
     * @return Slide
     * @throws \Exception
     */
	public static function getById($idSlide) {
		$conn = DB::getConnection();
            
        $query = "SELECT `idSlide`, `imagem`, `ordem` FROM `Slide` WHERE `idSlide` = ?;";
        
        $stmt = $conn->prepare($query);            
        if($stmt === FALSE){
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }            
        if($stmt->bind_param("i", $idSlide) === FALSE){
            throw new \Exception("Falha ao associar parâmetros. Erro: {$stmt->error} ");
        }
        
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }            
        $result = $stmt->get_result();            
       
        if($row = $result->fetch_assoc()){
            $slide = new Slide($row['idSlide'], $row['imagem'], $row['ordem']);
        } else {
            $slide = NULL;
        }
        $result->close();             
        return $slide;
	}

    /**
     * Retorna uma lista de todos produtos
     * @return Slides
     * @throws \Exception
     */
	public static function getSlides() {
        $slides = []; 
		$conn = DB::getConnection();
            
        $query = "SELECT `idSlide`, `imagem`, `ordem` FROM `Slide`;";
        
        $result = $conn->query($query);
         
        if($result === FALSE){
            throw new \Exception("Falha ao carregar lista de slides. Erro: {$conn->error} ");
        }
        while($row = $result->fetch_assoc()){
            $slides[] = new Slide($row['idSlide'], $row['imagem'], $row['ordem']);
        }
        $result->close();
         
        return $slides; 
	}

    /**
     * Insere um Slide no banco de dados     
     * @param $slide objeto Slide
     * @throws \Exception
     */
	public static function insere($slide) {
		$conn = DB::getConnection();   
            
        $query = 'INSERT INTO `Slide` (`imagem`, `ordem`) VALUES (?,?);';
        $stmt = $conn->prepare($query);
        if($stmt == FALSE){
            throw new Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }
        	
        $imagem = $slide->getImagem();	
        $ordem = $slide->getOrdem();

        if($stmt->bind_param("si", $imagem, $ordem) === FALSE){
            throw new \Exception("Falha ao assossiar parâmetros. Erro: {$stmt->error}");
        }
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }      
        $stmt->close();
	}

    /**
     * Atualiza um Slide no banco de dados     
     * @param $produto objeto Slide
     * @throws \Exception
     */  
	public static function atualiza($slide) {
		$conn = DB::getConnection();   
            
        $query = 'UPDATE `Slide` SET `imagem`=?, `ordem`=? WHERE `idSlide` = ?;';
        $stmt = $conn->prepare($query);
        if($stmt == FALSE){
            throw new Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }
        
        $idSlide = $slide->getIdSlide();	
        $imagem = $slide->getImagem();	
        $ordem = $slide->getOrdem();

        if($stmt->bind_param("sii", $imagem, $ordem, $idSlide) === FALSE){
            throw new \Exception("Falha ao assossiar parâmetros. Erro: {$stmt->error}");
        }
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }      
        $stmt->close();
	}

    /**
     * Deleta um Slide do banco de dados     
     * @param integer $idSlide ID do Slide
     * @throws \Exception
     */  
	public static function deleta($idSlide) {
		$conn = DB::getConnection();   
            
        $query = 'DELETE FROM `Slide` WHERE `idSlide` = ?;';
        $stmt = $conn->prepare($query);
        if($stmt == FALSE){
            throw new Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }
        if($stmt->bind_param("i",  $idSlide) === FALSE){
            throw new \Exception("Falha ao assossiar parâmetros. Erro: {$stmt->error}");
        }
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }      
        $stmt->close();
	}

	public function getIdSlide(){
		return $this->idSlide;
	}

	public function setIdSlide($idSlide){
		$this->idSlide = $idSlide;
	}

	public function getImagem(){
		return $this->imagem;
	}

	public function setImagem($imagem){
		$this->imagem = $imagem;
	}

	public function getOrdem(){
		return $this->ordem;
	}

	public function setOrdem($ordem){
		$this->ordem = $ordem;
	}
}
