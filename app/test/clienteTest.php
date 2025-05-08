<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../models/Cliente.php';

class ClienteTest extends TestCase {
    // Se definen las propiedades de la clase, las cuales se usan en los tests.
    private $cliente; // Instancia del objeto Cliente que será probado.
    private $mockDb;  // Simulación de la conexión a la base de datos (mysqli).

    // Método que se ejecuta antes de cada prueba para preparar el entorno.
    protected function setUp(): void {
        // Se crea un objeto simulado de la clase mysqli.
        $this->mockDb = $this->createMock(mysqli::class);
    }

    // Prueba para el caso de guardar un nuevo cliente exitosamente.
    public function testGuardarClienteNuevoExitoso() {
        // Datos de entrada para crear un nuevo cliente.
        $data = [
            'cedula' => '0959112368',
            'nombre' => 'Bryan',
            'apellido' => 'Carranza',
            'telefono' => '0980616659',
            'direccion' => 'Av. Siempre Viva',
            'id' => null // El id es null porque es un cliente nuevo.
        ];
    
        // Mock de mysqli_stmt (sentencia preparada) para simular la ejecución exitosa.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('execute')->willReturn(true); // Simulamos que execute() retorna true.
    
        // Simulamos que prepare() devuelve nuestro mock de la sentencia preparada.
        $this->mockDb->method('prepare')->willReturn($mockStmt);
    
        // Creamos un mock de la clase Cliente y simulamos que cedulaExiste() devuelve false (no hay cliente con esa cédula).
        $this->cliente = $this->getMockBuilder(Cliente::class)
            ->setConstructorArgs([$this->mockDb])
            ->onlyMethods(['cedulaExiste'])
            ->getMock();
    
        // Configuramos cedulaExiste para que devuelva false.
        $this->cliente->method('cedulaExiste')->willReturn(false);
    
        // Llamamos al método guardar con los datos del cliente.
        $resultado = $this->cliente->guardar($data);
    
        // Verificamos que el resultado tenga la clave 'success' y que su valor sea true.
        $this->assertArrayHasKey('success', $resultado);
        $this->assertTrue($resultado['success']);
    }
    
    // Prueba para el caso de intentar guardar un cliente con una cédula duplicada.
    public function testGuardarClienteDuplicado() {
        // Datos de un cliente con cédula duplicada.
        $data = [
            'cedula' => '1234567890',
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'telefono' => '0999999999',
            'direccion' => 'Av. Siempre Viva',
            'id' => null
        ];
    
        // Simulamos que cedulaExiste() devuelve true (cédula ya existe en la base de datos).
        $this->cliente = $this->getMockBuilder(Cliente::class)
            ->setConstructorArgs([$this->mockDb])
            ->onlyMethods(['cedulaExiste'])
            ->getMock();
    
        $this->cliente->method('cedulaExiste')->willReturn(true);
    
        $_SESSION = []; // Limpiamos la sesión antes de la prueba.
        // Intentamos guardar el cliente con cédula duplicada.
        $this->cliente->guardar($data);
    
        // Verificamos que el mensaje de error fue guardado en la sesión.
        $this->assertEquals('Ya existe un cliente con esa cédula', $_SESSION['error']);
    }

    // Prueba para actualizar un cliente exitosamente.
    public function testActualizarClienteExitoso() {
        // Datos de cliente para actualizar.
        $data = [
            'cedula' => '0980616659',
            'nombre' => 'Alex',
            'apellido' => 'Freijo',
            'telefono' => '0959112368',
            'direccion' => 'Fertiza',
            'id' => 1 // El id existe, por lo que será una actualización.
        ];
    
        // Mock del statement con execute() exitoso.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('execute')->willReturn(true);
    
        // Simulamos que prepare() devuelve el mock del statement.
        $this->mockDb->method('prepare')->willReturn($mockStmt);
    
        // Creamos un mock del modelo Cliente y configuramos cedulaExiste() para devolver false (la cédula no existe).
        $clienteMock = $this->getMockBuilder(Cliente::class)
            ->setConstructorArgs([$this->mockDb])
            ->onlyMethods(['cedulaExiste'])
            ->getMock();
    
        $clienteMock->method('cedulaExiste')->willReturn(false);
    
        // Llamamos al método guardar con los datos del cliente para actualizarlo.
        $resultado = $clienteMock->guardar($data);
    
        // Verificamos que el resultado tenga la clave 'success' y que su valor sea true.
        $this->assertArrayHasKey('success', $resultado);
        $this->assertTrue($resultado['success']);
    }
    
    // Prueba para eliminar un cliente exitosamente.
    public function testEliminarClienteExitoso() {
        // Creamos una instancia del modelo Cliente.
        $cliente = new Cliente($this->mockDb);
    
        // ID del cliente a eliminar.
        $id = 1;
    
        // Mock de prepared statement para simular la ejecución exitosa.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('execute')->willReturn(true);
    
        // Simulamos que prepare() devuelve el mock del statement.
        $this->mockDb->method('prepare')->willReturn($mockStmt);
    
        // Llamamos al método eliminar con el ID del cliente.
        $resultado = $cliente->eliminar($id);
    
        // Verificamos que el resultado sea true (indica que la eliminación fue exitosa).
        $this->assertTrue($resultado);
    }
}

?>