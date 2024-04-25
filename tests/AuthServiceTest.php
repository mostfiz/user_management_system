<?php
    require_once __DIR__ . '/../Services/AuthService.php'; 

    use PHPUnit\Framework\TestCase;

    class AuthServiceTest extends TestCase {
        private $authService;
        private $mockDb;

        protected function setUp(): void {
            parent::setUp();
            // Mock the database connection
            $this->mockDb = $this->createMock(PDO::class);
            // Create an instance of AuthService with mock database connection
            $this->authService = new AuthService($this->mockDb);
        }

        public function testLoginWithValidCredentials(): void {
            // Mock the database query result for a valid user
            $validUser = ['username' => 'testuser', 'password' => password_hash('password123', PASSWORD_BCRYPT)];
            $stmtMock = $this->createMock(PDOStatement::class);
            $stmtMock->expects($this->once())
                    ->method('execute')
                    ->willReturn(true);
            $stmtMock->expects($this->once())
                    ->method('fetch')
                    ->willReturn($validUser);
            $this->mockDb->expects($this->once())
                        ->method('prepare')
                        ->willReturn($stmtMock);

            // Call the login method with valid credentials
            $result = $this->authService->login('testuser', 'password123');

            // Assert that the login is successful and user details are returned
            $this->assertTrue($result['success']);
            $this->assertArrayHasKey('user', $result);
            $this->assertEquals($validUser['username'], $result['user']['username']);
        }

        public function testLoginWithInvalidCredentials(): void {
            // Mock the database query result for an invalid user
            $stmtMock = $this->createMock(PDOStatement::class);
            $stmtMock->expects($this->once())
                    ->method('execute')
                    ->willReturn(true);
            $stmtMock->expects($this->once())
                    ->method('fetch')
                    ->willReturn(false);
            $this->mockDb->expects($this->once())
                        ->method('prepare')
                        ->willReturn($stmtMock);

            // Call the login method with invalid credentials
            $result = $this->authService->login('invaliduser', 'wrongpassword');

            // Assert that the login fails and an error message is returned
            $this->assertFalse($result['success']);
            $this->assertEquals('Invalid username or password', $result['message']);
        }
    }
?>