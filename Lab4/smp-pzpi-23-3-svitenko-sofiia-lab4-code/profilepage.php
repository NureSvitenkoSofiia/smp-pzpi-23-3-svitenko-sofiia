<?php
function validateUserData($data) {
    $errors = [];

    if (empty(trim($data['first']))) {
        $errors[] = "Ім'я не може бути порожнім";
    } elseif (strlen(trim($data['first'])) <= 1) {
        $errors[] = "Ім'я має містити більше одного символу";
    }

    if (empty(trim($data['last']))) {
        $errors[] = "Прізвище не може бути порожнім";
    } elseif (strlen(trim($data['last'])) <= 1) {
        $errors[] = "Прізвище має містити більше одного символу";
    }

    if (empty($data['birth'])) {
        $errors[] = "Дата народження обов'язкова";
    } else {
        $dob = new DateTime($data['birth']);
        $now = new DateTime();
        $years = $dob->diff($now)->y;

        if ($years < 16) {
            $errors[] = "Вам має бути не менше 16 років";
        }
    }

    if (empty(trim($data['bio']))) {
        $errors[] = "Опис не може бути порожнім";
    } elseif (strlen(trim($data['bio'])) < 50) {
        $errors[] = "Опис має містити не менше 50 символів";
    }

    return $errors;
}

$profileErrors = [];
$imageErrors = [];

if (isset($_POST['updateProfile'])) {
    session_start();
    $userData = [
        'first' => $_POST['name'] ?? '',
        'last' => $_POST['surname'] ?? '',
        'birth' => $_POST['dob'] ?? '',
        'bio' => $_POST['description'] ?? ''
    ];

    $profileErrors = validateUserData($userData);

    if (empty($profileErrors)) {
        $profile = $_SESSION['profile'] ?? [];

        $profile['name'] = trim($userData['first']);
        $profile['surname'] = trim($userData['last']);
        $profile['dob'] = $userData['birth'];
        $profile['description'] = trim($userData['bio']);

        $_SESSION['profile'] = $profile;
        $_SESSION['success_message'] = "Дані профілю успішно оновлено";

        header("Location: ./index.php?page=profilepage");
        exit();
    } else {
        $_SESSION['temp_profile_data'] = $userData;
        $_SESSION['profile_errors'] = $profileErrors;

        header("Location: ./index.php?page=profilepage");
        exit();
    }
}

if (isset($_POST['uploadImage'])) {
    session_start();
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
        $tempPath = $_FILES['profilePicture']['tmp_name'];
        $originalName = $_FILES['profilePicture']['name'];
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $targetDir = __DIR__ . './assets/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $uniqueName = uniqid('profile_', true) . '.' . $ext;
        $targetPath = $targetDir . $uniqueName;

        if (move_uploaded_file($tempPath, $targetPath)) {
            $profile = $_SESSION['profile'] ?? [];
            $profile['image'] = 'assets/' . $uniqueName;
            $_SESSION['profile'] = $profile;
            $_SESSION['success_message'] = "Зображення профілю успішно оновлено";
        } else {
            $imageErrors[] = "Помилка при завантаженні зображення";
            $_SESSION['image_errors'] = $imageErrors;
        }
        
    } else {
        $imageErrors[] = "Будь ласка, виберіть зображення";
        $_SESSION['image_errors'] = $imageErrors;
    }

    header("Location: ./index.php?page=profilepage");
    exit();
}

$profileErrors = $_SESSION['profile_errors'] ?? [];
$imageErrors = $_SESSION['image_errors'] ?? [];
$successMessage = $_SESSION['success_message'] ?? '';

unset($_SESSION['profile_errors']);
unset($_SESSION['image_errors']);
unset($_SESSION['success_message']);

$profile = $_SESSION['profile'] ?? [];
$tempData = $_SESSION['temp_profile_data'] ?? [];
unset($_SESSION['temp_profile_data']);

$first = $tempData['first'] ?? ($profile['name'] ?? '');
$last = $tempData['last'] ?? ($profile['surname'] ?? '');
$birth = $tempData['birth'] ?? ($profile['dob'] ?? '');
$bio = $tempData['bio'] ?? ($profile['description'] ?? '');
$imagePath = $profile['image'] ?? null;
?>

<link rel="stylesheet" href="./styles/profile.css">
<div class="profile-container">
    <h1>User Profile</h1>

    <?php if ($successMessage): ?>
        <div class="success-message"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>

    <div class="profile-form-container">
        <div class="image-form-container">
            <h2>Profile Picture</h2>

            <?php if (!empty($imageErrors)): ?>
                <div class="error-messages">
                    <?php foreach ($imageErrors as $err): ?>
                        <p class="error"><?= htmlspecialchars($err) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="profilepage.php" method="POST" enctype="multipart/form-data" class="image-form">
                <div class="image-preview">
                    <?php if ($imagePath): ?>
                        <img src="<?= htmlspecialchars($imagePath) ?>" alt="Profile Picture">
                    <?php else: ?>
                        <div class="placeholder">Немає зображення</div>
                    <?php endif; ?>
                </div>
                <div class="file-input-container">
                    <input type="file" id="profilePicture" name="profilePicture" accept="image/jpeg,image/png,image/gif">
                    <button type="submit" name="uploadImage">Зберегти зображення</button>
                </div>
            </form>
        </div>

        <div class="profile-form-container">
            <h2>Personal Information</h2>

            <?php if (!empty($profileErrors)): ?>
                <div class="error-messages">
                    <?php foreach ($profileErrors as $err): ?>
                        <p class="error"><?= htmlspecialchars($err) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="profilepage.php" method="POST" class="profile-form">
                <div class="row">
                    <div class="form-group">
                        <label for="name">Ім'я:</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($first) ?>">
                    </div>

                    <div class="form-group">
                        <label for="surname">Прізвище:</label>
                        <input type="text" id="surname" name="surname" value="<?= htmlspecialchars($last) ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="dob">Дата народження:</label>
                    <input type="date" id="dob" name="dob" value="<?= htmlspecialchars($birth) ?>">
                </div>

                <div class="form-group">
                    <label for="description">Короткий опис:</label>
                    <textarea id="description" name="description" rows="7"><?= htmlspecialchars($bio) ?></textarea>
                </div>

                <div class="buttons">
                    <button type="submit" name="updateProfile">Зберегти</button>
                </div>
            </form>
        </div>
    </div>
</div>
