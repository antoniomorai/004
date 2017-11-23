<?php

namespace LoteriaApi;

class ConfigTest extends \PHPUnit_Framework_TestCase {
    private $config;
    
    public function testConfigClassExist() {
        $this->assertTrue(
                class_exists($class = 'LoteriaApi\Config'),
                'Class not found: '.$class
        );
    }
    
    public function setUp() {
        $this->config = new Config();
    }
    
    public function testSetApiPathShouldReturnInstanceOfConfig() {
        $instance = $this->config->setApiPath(API_PATH);
        $this->assertInstanceOf('LoteriaApi\Config', $instance);
    }
    
    public function testSetDirectoryShouldReturnInstanceOfConfig() {
        $instance = $this->config->setDirectory('etc');
        $this->assertInstanceOf('LoteriaApi\Config', $instance);
    }
    
    public function testSetFileNameShouldReturnInstanceOfConfig() {
        $instance = $this->config->setFileName('datasource');
        $this->assertInstanceOf('LoteriaApi\Config', $instance);
    }
    
    public function testSetExtShouldReturnInstanceOfConfig() {
        $instance = $this->config->setExt('yml');
        $this->assertInstanceOf('LoteriaApi\Config', $instance);        
    }
    
    public function testGetDataShouldReturnAValidArray(){
        $config = $this->config->setApiPath(API_PATH)
            ->setDirectory('etc')
            ->setExt('ini');
        
        $datasource = $config->setFileName('datasource')
            ->getData();
        
        $this->assertTrue(is_array($datasource));
        $this->assertEquals([
            'megasena' => [
                'name'   => 'Mega-Sena',
                'url'    => 'http://www1.caixa.gov.br/loterias/_arquivos/loterias/D_megase.zip',
                'zip'    => 'megasena.zip',
                'html'   => 'D_MEGA.HTM',
                'gif'    => 'T2.GIF',
                'reader' => 'LoteriaApi\Consumer\Reader\HtmlMegasena',
                'xml'    => 'megasena.xml',
            ],
            'lotofacil' => [
                'name'    => "Lotofácil",
                'url'     => "http://www1.caixa.gov.br/loterias/_arquivos/loterias/D_lotfac.zip",
                'zip'     => "lotofacil.zip",
                'html'    => "D_LOTFAC.HTM",
                'gif'     => "LOTFACIL.GIF",
                'xml'     => "lotofacil.xml",
                'reader'  => "LoteriaApi\Consumer\Reader\HtmlLotofacil",
            ],
            'quina' => [
                'name'    => "Quina",
                'url'     => "http://www1.caixa.gov.br/loterias/_arquivos/loterias/D_quina.zip",
                'zip'     => "quina.zip",
                'html'    => "D_QUINA.HTM",
                'gif'     => "T7.GIF",
                'xml'     => "quina.xml",
                'reader'  => "LoteriaApi\Consumer\Reader\HtmlQuina",
            ],
            'lotomania' => [
                'name'    => "Lotomania",
                'url'     => "http://www1.caixa.gov.br/loterias/_arquivos/loterias/D_lotoma.zip",
                'zip'     => "lotomania.zip",
                'html'    => "D_LOTMAN.HTM",
                'gif'     => "T11.GIF",
                'xml'     => "lotomania.xml",
                'reader'  => "LoteriaApi\Consumer\Reader\HtmlLotomania",
            ]
        ], $datasource);
        
        $path = $config->setFileName('path')
            ->getData();
        
        $this->assertTrue(is_array($path));
        $this->assertEquals([
            'path' => [
                'zip' => API_PATH . 'var' . DS . 'zip' . DS,
                'ext' => API_PATH . 'var' . DS . 'ext' . DS,
                'xml' => API_PATH . 'var' . DS . 'xml' . DS,
            ]
        ], $path);
    }
 
    /**
     * @expectedException Exception
     * @expectedExceptionMessage File does not exist 
     */
    public function testGetDataShouldThrownAnException(){
        $this->config->setDirectory('etc')
            ->setFileName('noexist')
            ->setExt('ini')
            ->getData();
    }
}