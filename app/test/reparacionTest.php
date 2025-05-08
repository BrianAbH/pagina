<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../models/Reparacion.php';

class ReparacionTest extends TestCase {
    private $mockDb; // Se declara una propiedad para almacenar el mock de la base de datos (mysqli).

    // Método que se ejecuta antes de cada prueba para configurar el entorno.
    protected function setUp(): void {
        // Se crea un mock de la clase mysqli, que simula el comportamiento de la base de datos.
        $this->mockDb = $this->createMock(mysqli::class);
    }

    // Prueba para guardar una nueva reparación.
    public function testGuardarReparacionNuevaExitoso() {
        // Datos para guardar una nueva reparación.
        $data = [
            'id' => null, // id es null porque estamos creando una nueva reparación.
            'movil' => 1,
            'tecnico' => 2,
            'repuestos' => 'Pantalla, Batería',
            'total_repuestos' => 100,
            'servicio' => 'Cambio de pantalla',
            'total_servicio' => 50,
            'FechaReparacion' => '30-04-2025'
        ];

        // Simulación de la sentencia preparada.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('execute')->willReturn(true); // Simula la ejecución exitosa de la sentencia.
        $this->mockDb->method('prepare')->willReturn($mockStmt); // Simula que el método prepare() retorna el mock.

        // Instanciamos la clase Reparacion con el mock de la base de datos.
        $reparacion = new Reparacion($this->mockDb);
        $resultado = $reparacion->guardar($data); // Llamamos al método guardar().

        // Verificamos que el resultado sea un array y contenga la clave 'success' con valor true.
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('success', $resultado);
        $this->assertTrue($resultado['success']);
    }

    // Prueba para actualizar una reparación existente.
    public function testGuardarReparacionActualizarExitoso() {
        // Datos para actualizar una reparación existente (id distinto de null).
        $data = [
            'id' => 1, // id es 1 porque es una reparación existente.
            'movil' => 1,
            'tecnico' => 2,
            'repuestos' => 'Pantalla',
            'total_repuestos' => 80,
            'servicio' => 'Revisión general',
            'total_servicio' => 40,
            'FechaReparacion' => '29-04-2025'
        ];

        // Simulación de la sentencia preparada.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('execute')->willReturn(true); // Simula la ejecución exitosa de la sentencia.
        $this->mockDb->method('prepare')->willReturn($mockStmt); // Simula que el método prepare() retorna el mock.

        // Instanciamos la clase Reparacion con el mock de la base de datos.
        $reparacion = new Reparacion($this->mockDb);
        $resultado = $reparacion->guardar($data); // Llamamos al método guardar().

        // Verificamos que el resultado sea un array y contenga la clave 'success' con valor true.
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('success', $resultado);
        $this->assertTrue($resultado['success']);
    }

    // Prueba para eliminar una reparación.
    public function testEliminarReparacionExitoso() {
        // Simulación de la sentencia preparada.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('execute')->willReturn(true); // Simula la ejecución exitosa de la sentencia.
        $this->mockDb->method('prepare')->willReturn($mockStmt); // Simula que el método prepare() retorna el mock.

        // Instanciamos la clase Reparacion con el mock de la base de datos.
        $reparacion = new Reparacion($this->mockDb);
        $resultado = $reparacion->eliminar(1); // Llamamos al método eliminar().

        // Verificamos que la eliminación sea exitosa.
        $this->assertTrue($resultado);
    }

    // Prueba para obtener todas las reparaciones.
    public function testObtenerReparaciones() {
        // Simulamos un resultado de base de datos que contiene una reparación.
        $mockResult = $this->createMock(mysqli_result::class);
        $mockResult->method('fetch_all')->willReturn([
            [
                'Id_Reparacion' => 1,
                'Nombre_Completo' => 'Luis Alvarez',
                'Id_Tecnico' => 2,
                'Nombre_Tecnico' => 'Carlos Mejía',
                'Id_Dispositivo' => 3,
                'Tipo' => 'Tablet',
                'Marca' => 'Apple',
                'Modelo' => 'iPad Pro',
                'Repuestos' => 'Pantalla',
                'Total_Repuestos' => 150,
                'Servicio' => 'Cambio',
                'Total_Servicio' => 60,
                'Fecha_Reparacion' => '2024-05-01'
            ]
        ]);

        // Simulación de la sentencia preparada.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('get_result')->willReturn($mockResult); // Simula que get_result() retorna el resultado simulado.
        $this->mockDb->method('prepare')->willReturn($mockStmt); // Simula que el método prepare() retorna el mock.

        // Instanciamos la clase Reparacion con el mock de la base de datos.
        $reparacion = new Reparacion($this->mockDb);
        $resultado = $reparacion->obtenerReparacion(); // Llamamos al método obtenerReparacion().

        // Verificamos que el resultado sea un array con un solo elemento.
        $this->assertIsArray($resultado);
        $this->assertCount(1, $resultado);
        $this->assertEquals('Luis Alvarez', $resultado[0]['Nombre_Completo']);
    }

    // Prueba para obtener los dispositivos relacionados con un cliente.
    public function testObtenerDispositivosByCliente() {
        // Simulamos un resultado de base de datos que contiene un dispositivo relacionado con un cliente.
        $mockResult = $this->createMock(mysqli_result::class);
        $mockResult->method('fetch_all')->willReturn([
            ['Id_Dispositivo' => 1, 'Nombre_Completo' => 'Juan Perez', 'Modelo' => 'Galaxy S21']
        ]);

        // Simulación de la sentencia preparada.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('get_result')->willReturn($mockResult); // Simula que get_result() retorna el resultado simulado.
        $this->mockDb->method('prepare')->willReturn($mockStmt); // Simula que el método prepare() retorna el mock.

        // Instanciamos la clase Reparacion con el mock de la base de datos.
        $reparacion = new Reparacion($this->mockDb);
        $resultado = $reparacion->obtenerDispositivosByCliente(); // Llamamos al método obtenerDispositivosByCliente().

        // Verificamos que el resultado sea un array con un solo dispositivo.
        $this->assertIsArray($resultado);
        $this->assertCount(1, $resultado);
        $this->assertEquals('Juan Perez', $resultado[0]['Nombre_Completo']);
    }

    // Prueba para obtener los técnicos relacionados con una reparación.
    public function testObtenerTecnicoById() {
        // Simulamos un resultado de base de datos que contiene un técnico.
        $mockResult = $this->createMock(mysqli_result::class);
        $mockResult->method('fetch_all')->willReturn([
            ['Id_Tecnico' => 2, 'Nombre_Tecnico' => 'Carlos Mejía']
        ]);

        // Simulación de la sentencia preparada.
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('get_result')->willReturn($mockResult); // Simula que get_result() retorna el resultado simulado.
        $this->mockDb->method('prepare')->willReturn($mockStmt); // Simula que el método prepare() retorna el mock.

        // Instanciamos la clase Reparacion con el mock de la base de datos.
        $reparacion = new Reparacion($this->mockDb);
        $resultado = $reparacion->obtenerTecnicoById(); // Llamamos al método obtenerTecnicoById().

        // Verificamos que el resultado sea un array con un solo técnico.
        $this->assertIsArray($resultado);
        $this->assertCount(1, $resultado);
        $this->assertEquals('Carlos Mejía', $resultado[0]['Nombre_Tecnico']);
    }
}


?>