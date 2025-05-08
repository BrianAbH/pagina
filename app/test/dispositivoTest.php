<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../models/Dispositivo.php';

class DispositivoTest extends TestCase {

    private $mockDb; // Objeto simulado de la conexión a la base de datos (mysqli).

    // Método que se ejecuta antes de cada prueba para configurar el entorno.
    protected function setUp(): void {
        // Se crea un mock de la clase mysqli, que simula el comportamiento de la base de datos.
        $this->mockDb = $this->createMock(mysqli::class);
    }

    // Prueba para el caso de guardar un nuevo dispositivo exitosamente.
    public function testGuardarDispositivoNuevoExitoso() {
        // Datos del dispositivo a guardar.
        $data = [
            'id' => null, // id es null porque es un dispositivo nuevo.
            'cliente' => 1,
            'tipo' => 'Smartphone',
            'marca' => 'Samsung',
            'modelo' => 'Galaxy S21',
            'anio' => 2021
        ];

        // Simulación de la sentencia preparada.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('bind_param')->willReturn(true); // Simula el comportamiento de bind_param.
        $mockStmt->method('execute')->willReturn(true); // Simula que la ejecución de la sentencia es exitosa.
    
        // Simulamos que el método prepare() retorna la sentencia preparada mockeada.
        $this->mockDb->method('prepare')->willReturn($mockStmt);
    
        // Creamos una instancia del objeto Dispositivo con la base de datos simulada.
        $dispositivo = new Dispositivo($this->mockDb);
    
        // Llamamos al método guardar() y verificamos el resultado.
        $resultado = $dispositivo->guardar($data);
    
        // Verificamos que el resultado tenga la clave 'success' y que su valor sea true.
        $this->assertArrayHasKey('success', $resultado);
        $this->assertTrue($resultado['success']);
    }

    // Prueba para el caso de actualizar un dispositivo existente exitosamente.
    public function testGuardarDispositivoActualizarExitoso() {
        // Datos del dispositivo con id (para actualizarlo).
        $data = [
            'id' => 1, // id no es null, es un dispositivo existente.
            'cliente' => 1,
            'tipo' => 'Smartphone',
            'marca' => 'IPhone',
            'modelo' => 'Xr',
            'anio' => 2023
        ];
    
        // Simulación de la sentencia preparada.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('bind_param')->willReturn(true); // Simula el comportamiento de bind_param.
        $mockStmt->method('execute')->willReturn(true); // Simula que la ejecución de la sentencia es exitosa.

        // Simulamos que el método prepare() retorna la sentencia preparada mockeada.
        $this->mockDb->method('prepare')->willReturn($mockStmt);

        // Creamos una instancia del objeto Dispositivo con la base de datos simulada.
        $dispositivo = new Dispositivo($this->mockDb);
    
        // Llamamos al método guardar() y verificamos el resultado.
        $resultado = $dispositivo->guardar($data);

        // Verificamos que el resultado tenga la clave 'success' y que su valor sea true.
        $this->assertArrayHasKey('success', $resultado);
        $this->assertTrue($resultado['success']);
    }

    // Prueba para el caso de eliminar un dispositivo exitosamente.
    public function testEliminarDispositivoExitoso() {
        // Creamos una instancia del objeto Dispositivo con la base de datos simulada.
        $dispositivo = new Dispositivo($this->mockDb);
    
        // Simulación de la sentencia preparada.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('execute')->willReturn(true); // Simula que la ejecución es exitosa.
    
        // Simulamos que el método prepare() retorna la sentencia preparada mockeada.
        $this->mockDb->method('prepare')->willReturn($mockStmt);
    
        // Llamamos al método eliminar() y verificamos que el resultado sea true.
        $resultado = $dispositivo->eliminar(1);
    
        // Verificamos que la eliminación fue exitosa.
        $this->assertTrue($resultado);
    }

    // Prueba para obtener dispositivos de la base de datos.
    public function testObtenerDispositivos() {
        // Simulamos un resultado de base de datos que contiene un dispositivo.
        $mockResult = $this->createMock(mysqli_result::class);
        $mockResult->method('fetch_all')->willReturn([
            [
                'Id_Dispositivo' => 1,
                'Id_Cliente' => 1,
                'Nombre_Completo' => 'Juan Perez',
                'Apellidos' => 'Perez',
                'Tipo' => 'Smartphone',
                'Marca' => 'Samsung',
                'Modelo' => 'Galaxy S21',
                'Año' => 2021,
                'Activo' => 1
            ]
        ]);

        // Simulación de la sentencia preparada.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('get_result')->willReturn($mockResult);

        // Simulamos que el método prepare() retorna la sentencia preparada mockeada.
        $this->mockDb->method('prepare')->willReturn($mockStmt);

        // Creamos una instancia del objeto Dispositivo con la base de datos simulada.
        $dispositivo = new Dispositivo($this->mockDb);
    
        // Llamamos al método obtenerDispositivos() y verificamos el resultado.
        $dispositivos = $dispositivo->obtenerDispositivos();
    
        // Verificamos que el resultado es un array y que contiene un dispositivo.
        $this->assertIsArray($dispositivos);
        $this->assertCount(1, $dispositivos);
        $this->assertEquals('Juan Perez', $dispositivos[0]['Nombre_Completo']);
    }

    // Prueba para obtener clientes relacionados con dispositivos.
    public function testObtenerByCliente() {
        // Simulamos un resultado de base de datos que contiene un cliente.
        $mockResult = $this->createMock(mysqli_result::class);
        $mockResult->method('fetch_all')->willReturn([
            [
                'Id_Cliente' => 1,
                'Nombre_Completo' => 'Juan Perez'
            ]
        ]);

        // Simulación de la sentencia preparada.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('get_result')->willReturn($mockResult);

        // Simulamos que el método prepare() retorna la sentencia preparada mockeada.
        $this->mockDb->method('prepare')->willReturn($mockStmt);

        // Creamos una instancia del objeto Dispositivo con la base de datos simulada.
        $dispositivo = new Dispositivo($this->mockDb);
    
        // Llamamos al método obtenerByCliente() y verificamos el resultado.
        $clientes = $dispositivo->obtenerByCliente();
    
        // Verificamos que el resultado es un array y que contiene un cliente.
        $this->assertIsArray($clientes);
        $this->assertCount(1, $clientes);
        $this->assertEquals('Juan Perez', $clientes[0]['Nombre_Completo']);
    }
}

?>