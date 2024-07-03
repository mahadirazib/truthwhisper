<?php
require_once '../config.php';

if (!isset($_GET['id'])) {
    setFlashMessage('danger', 'Please enter a valid url to give feedback!');
    include_once './errors/404_not_Found.php';
    exit;
}

$userId = $_GET['id'];
$usersFile = '../data/users.json';
$users = json_decode(file_get_contents($usersFile), true);

if (!isset($users[$userId])) {
    setFlashMessage('danger', 'This link does not belongs to anyone!');
    include_once './errors/404_not_Found.php';
    exit;
} else {
    $user = $users[$userId];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // $feedback = htmlspecialchars($_POST['feedback']);
    $feedback = [];
    $comment = htmlspecialchars($_POST['feedback']);
    $behavior = (int)$_POST['behavior'];
    $intelligence = (int)$_POST['intelligence'];
    $friendliness = (int)$_POST['friendliness'];
    $emotional = (int)$_POST['emotional'];

    $feedback['comment'] = $comment;
    $feedback['behavior'] = $behavior;
    $feedback['intelligence'] = $intelligence;
    $feedback['friendliness'] = $friendliness;
    $feedback['emotional'] = $emotional;

    $feedbacksFile = "../data/feedback/$userId.json";
    $feedbacks = file_exists($feedbacksFile) ? json_decode(file_get_contents($feedbacksFile), true) : [];

    $feedbacks[] = $feedback;
    // print_r($feedback);
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
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"/>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <?php require_once './components/header.php' ?>

    <main class="">
        <div class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray-50 py-6 sm:py-12">
            <img src="./images/beams.jpg" alt="" class="absolute top-1/2 left-1/2 max-w-none -translate-x-1/2 -translate-y-1/2" width="1308" />
            <div class="absolute inset-0 bg-[url(./images/grid.svg)] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
            <div class="relative bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10">
                <div class="mx-auto max-w-xl min-w-sm">
                    <div class="flex min-h-full flex-col justify-center px-6 py-6 lg:px-8">
                        <div class="mx-auto w-full max-w-xl text-center">
                            <h1 class="block text-center font-bold text-2xl bg-gradient-to-r from-blue-600 via-green-500 to-indigo-400 inline-block text-transparent bg-clip-text">TruthWhisper</h1>
                            <h3 class="text-gray-500 my-2">Share your view to <b><q><?= $user['name'] ?></q></b>. Give your honest response. </h3>
                        </div>

                        <div class="">
                            <?php displayFlashMessage(); ?>
                        </div>

                        <div class="mt-6 mx-auto w-full max-w-xl">
                            <form class="space-y-6" action="#" method="POST">

                                <div class="flex">
                                    <div class="flex-1">
                                        <label for="behavior" class="text-sm font-medium leading-6 text-gray-900">Behavior:</label>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-end">
                                            <select name="behavior" id="behavior" class="w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 p-3">
                                                <option value="1">Very Bad</option>
                                                <option value="2">Bad</option>
                                                <option value="3">Moderate</option>
                                                <option value="4">Good</option>
                                                <option value="5">Excellent</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>


                                <div class="flex">
                                    <div class="flex-1">
                                        <label for="intelligence" class="text-sm font-medium leading-6 text-gray-900">Intelligence:</label>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-end">
                                            <select name="intelligence" id="intelligence" class="w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 p-3">
                                                <option value="1">Very Low</option>
                                                <option value="2">Low</option>
                                                <option value="3">Average</option>
                                                <option value="4">High</option>
                                                <option value="5">Very High</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>


                                <div class="flex">
                                    <div class="flex-1">
                                        <label for="friendliness" class="text-sm font-medium leading-6 text-gray-900">Friendliness:</label>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-end">
                                            <select name="friendliness" id="friendliness" class="w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 p-3">
                                                <option value="1">Very Unfriendly</option>
                                                <option value="2">Unfriendly</option>
                                                <option value="3">Neutral</option>
                                                <option value="4">Friendly</option>
                                                <option value="5">Very Friendly</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>


                                <div class="flex">
                                    <div class="flex-1">
                                        <label for="emotional" class="text-sm font-medium leading-6 text-gray-900">Emotional Control:</label>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-end">
                                            <select name="emotional" id="emotional" class="w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 p-3">
                                                <option value="1">Very Low Control</option>
                                                <option value="2">Low Control</option>
                                                <option value="3">Moderate Control</option>
                                                <option value="4">Good Control</option>
                                                <option value="5">Excellent Control</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div>
                                    <label for="feedback" class="block text-sm font-medium leading-6 text-gray-900">Don't hesitate to say something, just do it!</label>
                                    <div class="mt-2">
                                        <textarea required name="feedback" id="feedback" rows="7" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 p-3"></textarea>
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