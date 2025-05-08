<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../models/Tecnico.php';

class tecnicoTest extends TestCase {
    private $tecnincoMock; // Propiedad para el mock del objeto Técnico (aunque no se usa en todos los casos).
    private $mockDb; // Propiedad para el mock de la base de datos (mysqli).

    // Método que se ejecuta antes de cada prueba para configurar el entorno.
    protected function setUp(): void {
        // Se crea un mock de la clase mysqli, que simula el comportamiento de la base de datos.
        $this->mockDb = $this->createMock(mysqli::class);
    }

    // Prueba para guardar un nuevo técnico exitosamente.
    public function testGuardarTecnicoNuevoExitoso() {
        // Datos para guardar un nuevo técnico.
        $data = [
            'cedula' => '1305048884',
            'nombre' => 'Luis',
            'apellido' => 'Diaz',
            'telefono' => '0959112368',
            'especialidad' => 'En teléfono Android',
            'id' => null // El id es null porque estamos creando un nuevo técnico.
        ];

        // Simulamos la sentencia preparada y su ejecución exitosa.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('execute')->willReturn(true); // Simula la ejecución exitosa de la sentencia.

        $this->mockDb->method('prepare')->willReturn($mockStmt); // Simula que el método prepare() retorna el mock.

        // Creamos un mock de la clase Tecnico, especificando que el método cedulaExiste será simulado.
        $tecnicoMock = $this->getMockBuilder(Tecnico::class)
            ->setConstructorArgs([$this->mockDb])
            ->onlyMethods(['cedulaExiste']) // Indicamos que sólo el método cedulaExiste será mockeado.
            ->getMock();

        // Definimos que el método cedulaExiste devolverá false (significa que no existe un técnico con la cédula).
        $tecnicoMock->method('cedulaExiste')->willReturn(false);

        // Llamamos al método guardar() para guardar el nuevo técnico.
        $resultado = $tecnicoMock->guardar($data);

        // Verificamos que el resultado sea un array y que contenga la clave 'success' con valor true.
        $this->assertArrayHasKey('success', $resultado);
        $this->assertTrue($resultado['success']);
    }

    // Prueba para guardar un técnico con una cédula duplicada.
    public function testGuardarTecnicoDuplicado() {
        // Datos para un técnico duplicado (con la misma cédula).
        $data = [
            'cedula' => '1305048884',
            'nombre' => 'Luis',
            'apellido' => 'Diaz',
            'telefono' => '0959112368',
            'especialidad' => 'En teléfono Android',
            'id' => null // El id es null porque estamos creando un nuevo técnico.
        ];

        // Creamos un mock de la clase Tecnico, especificando que el método cedulaExiste será simulado.
        $tecnicoMock = $this->getMockBuilder(Tecnico::class)
            ->setConstructorArgs([$this->mockDb])
            ->onlyMethods(['cedulaExiste']) // Mockeamos sólo el método cedulaExiste.
            ->getMock();

        // Definimos que el método cedulaExiste devolverá true (indica que la cédula ya está registrada).
        $tecnicoMock->method('cedulaExiste')->willReturn(true);

        $_SESSION = []; // Simulamos una sesión vacía para almacenar el error.

        // Llamamos al método guardar(), que debe establecer un error en la sesión debido a la cédula duplicada.
        $tecnicoMock->guardar($data);

        // Verificamos que la sesión contiene el mensaje de error correcto.
        $this->assertEquals('Ya existe un tecnico con esa cédula', $_SESSION['error']);
    }

    // Prueba para actualizar un técnico exitosamente.
    public function testActualizarTecnicoExitoso() {
        // Datos para actualizar un técnico (con id).
        $data = [
            'cedula' => '0980616659',
            'nombre' => 'Doug',
            'apellido' => 'Alvarez',
            'telefono' => '0959358565',
            'especialidad' => 'En teléfono Xiaomi',
            'id' => 1 // El id es 1 porque es una actualización de un técnico existente.
        ];

        // Simulamos la sentencia preparada y su ejecución exitosa.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('execute')->willReturn(true); // Simula la ejecución exitosa de la sentencia.

        $this->mockDb->method('prepare')->willReturn($mockStmt); // Simula que el método prepare() retorna el mock.

        // Creamos un mock de la clase Tecnico, especificando que el método cedulaExiste será simulado.
        $tecnicoMock = $this->getMockBuilder(Tecnico::class)
            ->setConstructorArgs([$this->mockDb])
            ->onlyMethods(['cedulaExiste']) // Mockeamos sólo el método cedulaExiste.
            ->getMock();

        // Definimos que el método cedulaExiste devolverá false (indica que la cédula no está registrada).
        $tecnicoMock->method('cedulaExiste')->willReturn(false);

        // Llamamos al método guardar() para actualizar el técnico.
        $resultado = $tecnicoMock->guardar($data);

        // Verificamos que el resultado sea un array y que contenga la clave 'success' con valor true.
        $this->assertArrayHasKey('success', $resultado);
        $this->assertTrue($resultado['success']);
    }

    // Prueba para eliminar un técnico.
    public function testEliminarTecnicoExitoso() {
        // Creamos una instancia de la clase Tecnico.
        $tecnico = new Tecnico($this->mockDb);

        // Simulamos la sentencia preparada y su ejecución exitosa.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('execute')->willReturn(true); // Simula la ejecución exitosa de la sentencia.

        $this->mockDb->method('prepare')->willReturn($mockStmt); // Simula que el método prepare() retorna el mock.

        // Llamamos al método eliminar() con un id de técnico.
        $resultado = $tecnico->eliminar(100);

        // Verificamos que la eliminación sea exitosa.
        $this->assertTrue($resultado);
    }
}

?>

