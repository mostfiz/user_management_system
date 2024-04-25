<?php

    require_once __DIR__ . '/../Services/UserService.php';
    require_once __DIR__ . '/../Services/RoleManagerService.php'; 
    require_once __DIR__ . '/../Services/SecurityService.php'; 
    require_once __DIR__ . '/../Services/ErrorHandler.php'; 

    use PHPUnit\Framework\TestCase;

    class UserTest extends TestCase {
        private $userService;
        private $mockDb;

        protected function setUp(): void {
            parent::setUp();
            // Create mock objects for dependencies
            $this->mockDb = $this->createMock(PDO::class);
            // Create an instance of UserService with mock dependencies
            $this->userService = new UserService($this->mockDb);
        }

        public function testAddUser(): void {
            // Arrange
            $username = 'testuser';
            $email = 'test@example.com';
            $password = 'password123';
    
            // Mocking execute method of PDOStatement
            $stmtMock = $this->createMock(PDOStatement::class);
            $stmtMock->expects($this->once())
                     ->method('execute')
                     ->willReturn(true);
        
            // Mocking prepare method of PDO
            $this->mockDb->expects($this->once())
                         ->method('prepare')
                         ->willReturn($stmtMock);
        
            // Act
            $result = $this->userService->addUser($username, $email, $password);
        
            // Assert
            $this->assertTrue($result['success']);
            $this->assertEquals('User added successfully', $result['message']);
        }
        
        

        public function testEditUser(): void {
            // Arrange
            $userId = 1;
            $newUsername = 'newusername';
            $newEmail = 'newemail@example.com';
            $newPassword = 'newpassword123';
        
            // Mocking execute method of PDOStatement
            $stmtMock = $this->createMock(PDOStatement::class);
            $stmtMock->expects($this->once())
                     ->method('execute')
                     ->willReturn(true);
        
            // Mocking prepare method of PDO
            $this->mockDb->expects($this->once())
                         ->method('prepare')
                         ->willReturn($stmtMock);
        
            // Act
            $result = $this->userService->editUser($userId, $newUsername, $newEmail, $newPassword);
        
            // Assert
            $this->assertTrue($result['success']);
            $this->assertEquals('User updated successfully', $result['message']);
        }
        
        
        public function testDeleteUser(): void {
            // Arrange
            $userId = 1;
        
            // Mocking execute method of PDOStatement
            $stmtMock = $this->createMock(PDOStatement::class);
            $stmtMock->expects($this->once())
                     ->method('execute')
                     ->with([$userId])
                     ->willReturn(true);
        
            // Mocking prepare method of PDO
            $this->mockDb->expects($this->once())
                         ->method('prepare')
                         ->with("DELETE FROM users WHERE id=?")
                         ->willReturn($stmtMock);
        
            // Act
            $result = $this->userService->deleteUser($userId);
        
            // Assert
            $this->assertTrue($result['success']);
            $this->assertEquals('User deleted successfully', $result['message']);
        }
        
        
        public function testAssignRole(): void {
            // Arrange
            $userId = 1;
            $role = 'role';
        
            // Act
            $result = $this->userService->assignRole($userId, $role);
        
            // Assert
            $this->assertTrue($result['success']);
            $this->assertEquals('Role assigned successfully', $result['message']);
        }
        
        public function testRemoveRole(): void {
            // Arrange
            $userId = 1;
            $role = 'role';
        
            // Act
            $result = $this->userService->removeRole($userId, $role);
        
            // Assert
            $this->assertTrue($result['success']);
            $this->assertEquals('Role removed successfully', $result['message']);
        }
     
    }

?>