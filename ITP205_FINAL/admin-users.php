<?php
$page_title = 'User Management';
require_once 'includes/config.php';
requireLogin();
if (!isAdmin()) {
    header('Location: index.php');
    exit;
}

// fetch users from db
$stmt = $conn->prepare("SELECT ID, Name, Age, Email FROM users ORDER BY ID DESC");
$stmt->execute();
$result = $stmt->get_result();
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
$stmt->close();

include 'includes/header.php';
?>

<div class="section">
    <h1>User Management</h1>
    <p>View, edit, or delete user accounts.</p>

    <div style="margin-bottom: 1rem;">
        <button type="button" class="btn btn-add-user" id="openAddUserBtn">➕ Add User</button>
    </div>

    <div class="table-container">
        <table class="user-table" id="usersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['ID']); ?></td>
                            <td><?php echo htmlspecialchars($user['Name']); ?></td>
                            <td><?php echo htmlspecialchars($user['Age']); ?></td>
                            <td><?php echo htmlspecialchars($user['Email']); ?></td>
                            <td>
                                <a href="admin-user-edit.php?id=<?php echo $user['ID']; ?>" class="btn btn-edit">Edit</a>
                                <a href="admin-user-delete.php?id=<?php echo $user['ID']; ?>" 
                                    class="btn btn-delete" 
                                    onclick="return confirm('Are you sure you want to delete this user?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- add user modal -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New User</h2>
                <button class="close-btn" id="closeAddUserBtn">&times;</button>
            </div>

            <div class="modal-body">
                <form id="addUserForm" method="POST">
                    <input type="hidden" name="action" value="add_user">

                    <div class="form-group">
                        <label for="addUserName">Full Name</label>
                        <input type="text" id="addUserName" name="name" placeholder="Enter full name" required>
                    </div>

                    <div class="form-group">
                        <label for="addUserAge">Age</label>
                        <input type="text" id="addUserAge" name="age" placeholder="Enter age">
                    </div>

                    <div class="form-group">
                        <label for="addUserEmail">Email Address</label>
                        <input type="email" id="addUserEmail" name="email" placeholder="Enter email" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<style>
.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    align-items: center;
    justify-content: center;
}

.modal.show {
    display: flex;
}

.modal-content {
    background-color: #fff;
    border-radius: 8px;
    padding: 2rem;
    width: 400px;
    max-width: 90%;
    position: relative;
}

.modal-header h2 {
    margin: 0;
}

.close-btn {
    position: absolute;
    top: 0.5rem;
    right: 1rem;
    font-size: 1.5rem;
    background: none;
    border: none;
    cursor: pointer;
}

.section {
    padding: 2rem;
}

.table-container {
    overflow-x: auto;
    margin-left: 2rem;
    margin-right: 2rem;
}

.user-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.user-table th, .user-table td {
    border: 1px solid #ddd;
    padding: 0.75rem 1rem;
    text-align: left;
}

.user-table th {
    background-color: #f8f8f8;
    font-weight: 600;
}

.user-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.btn {
    display: inline-block;
    padding: 0.3rem 0.6rem;
    margin-right: 0.3rem;
    border-radius: 4px;
    text-decoration: none;
    color: white;
    font-size: 0.85rem;
}

.btn-edit { background-color: #4CAF50; }
.btn-delete { background-color: #dc3545; }

.btn-add-user {
    background-color: #667eea;
    color: white;
    padding: 0.4rem 0.7rem;
    border-radius: 4px;
    font-size: 0.9rem;
    cursor: pointer;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const openBtn = document.getElementById('openAddUserBtn');
    const closeBtn = document.getElementById('closeAddUserBtn');
    const modal = document.getElementById('addUserModal');
    const addUserForm = document.getElementById('addUserForm');
    const usersTable = document.getElementById('usersTable').querySelector('tbody');

    function openModal() {
        modal.classList.add('show');
        modal.style.display = 'flex';
        modal.querySelector('input[name="name"]').focus();
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.remove('show');
        setTimeout(() => modal.style.display = 'none', 300);
        document.body.style.overflow = '';
    }

    openBtn.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => {
        if (!modal.querySelector('.modal-content').contains(e.target)) closeModal();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('show')) closeModal();
    });

    // add user using AJAX
    addUserForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(addUserForm);

        fetch('admin-users-add-ajax.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const user = data.user;
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.ID}</td>
                    <td>${user.Name}</td>
                    <td>${user.Age}</td>
                    <td>${user.Email}</td>
                    <td>
                        <a href="admin-user-edit.php?id=${user.ID}" class="btn btn-edit">Edit</a>
                        <a href="admin-user-delete.php?id=${user.ID}" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                `;
                usersTable.prepend(row); // add to top
                addUserForm.reset();
                closeModal();
            } else {
                alert(data.error);
            }
        })
        .catch(err => {
            console.error(err);
            alert('Something went wrong.');
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
