<?php

    require_once __DIR__ . '/../Services/UserService.php';
    require_once __DIR__ . '/../Services/RoleManagerService.php'; 
    require_once __DIR__ . '/../Services/SecurityService.php'; 
    require_once __DIR__ . '/../Services/ErrorHandler.php'; 

    use PHPUnit\Framework\TestCase;

    class UserTest extends TestCase {
        private $userService;
        private $mockDb;
        private $mockRoleManagerService;
        private $mockSecurityService;
        private $mockErrorHandler;

        protected function setUp(): void {
            parent::setUp();
            // Create mock objects for dependencies
            $this->mockRoleManagerService = $this->createMock(RoleManagerService::class);
            $this->mockSecurityService = $this->createMock(SecurityService::class);
            $this->mockErrorHandler = $this->createMock(ErrorHandler::class);
            $this->mockDb = $this->createMock(PDO::class);
            // Create an instance of UserService with mock dependencies
            $this->userService = new UserService($this->mockRoleManagerService, $this->mockSecurityService, $this->mockErrorHandler, $this->mockDb);
        }

        public function testAddUser(): void
        {
            // Mocking validateInput method of ErrorHandler
            $this->mockErrorHandler->expects($this->once())
                                   ->method('validateInput')
                                   ->willReturn(true);

            // Mocking hashPassword method of SecurityService
            $this->mockSecurityService->expects($this->once())
                                      ->method('hashPassword')
                                      ->willReturn('hashedPassword123');
            
            // Mocking prepare and execute methods of PDO (database)
            $stmtMock = $this->createMock(PDOStatement::class);
            $stmtMock->expects($this->once())
                    ->method('execute')
                    ->willReturn(true);
            $this->mockDb->expects($this->once())
                        ->method('prepare')
                        ->willReturn($stmtMock);

            $this->assertTrue($this->userService->addUser('testuser', 'test@example.com', 'password123'));

        }
    }
?>