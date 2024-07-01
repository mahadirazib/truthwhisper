<?php
require_once '../config.php';

if (!isset($_GET['id'])) {
    setFlashMessage('danger', 'Please enter a valid url to give feedback!');
    include_once './errors/404_not_Found.php';
    exit;
}

$userId = $_GET['id'];
$usersFile = '../users/users.json';
$users = json_decode(file_get_contents($usersFile), true);

if (!isset($users[$userId])) {
    setFlashMessage('danger', 'This link does not belongs to anyone!');
    include_once './errors/404_not_Found.php';
    exit;
}else{
    $user = $users[$userId];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedback = htmlspecialchars($_POST['feedback']);
    $feedbacksFile = "../users/feedback/$userId.json";
    $feedbacks = file_exists($feedbacksFile) ? json_decode(file_get_contents($feedbacksFile), true) : [];

    $feedbacks[] = $feedback;
    file_put_contents($feedbacksFile, json_encode($feedbacks, JSON_PRETTY_PRINT));

    header("Location: feedback_success.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TruthWhisper - Anonymous Feedback App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<?php require_once './components/header.php' ?>

<main class="">
    <div class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray-50 py-6 sm:py-12">
        <img src="./images/beams.jpg" alt="" class="absolute top-1/2 left-1/2 max-w-none -translate-x-1/2 -translate-y-1/2" width="1308" />
        <div class="absolute inset-0 bg-[url(./images/grid.svg)] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
        <div class="relative bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10">
            <div class="mx-auto max-w-xl">
                <div class="flex min-h-full flex-col justify-center px-6 py-6 lg:px-8">
                    <div class="mx-auto w-full max-w-xl text-center">
                        <h1 class="block text-center font-bold text-2xl bg-gradient-to-r from-blue-600 via-green-500 to-indigo-400 inline-block text-transparent bg-clip-text">TruthWhisper</h1>
                        <h3 class="text-gray-500 my-2">Want to ask something or share a feedback to "<?= $user['name'] ?>"?</h3>
                    </div>

                    <div class="">
                        <?php displayFlashMessage(); ?>
                    </div>

                    <div class="mt-6 mx-auto w-full max-w-xl">
                        <form class="space-y-6" action="#" method="POST">
                            <div>
                                <label for="feedback" class="block text-sm font-medium leading-6 text-gray-900">Don't hesitate, just do it!</label>
                                <div class="mt-2">
                                    <textarea required name="feedback" id="feedback" cols="30" rows="7" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 p-3"></textarea>
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="bg-white">
    <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center justify-center lg:px-8">
        <p class="text-center text-xs leading-5 text-gray-500">&copy; 2024 TruthWhisper, Inc. All rights reserved.</p>
    </div>
</footer>

</body>
</html>

