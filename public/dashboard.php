<?php
require_once '../config.php';

$page = 'dashboard';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$uniq_url = $_ENV['DOMAIN'] . "/feedback.php?id=" . urlencode($userId);
$usersFile = '../data/users.json';
$users = json_decode(file_get_contents($usersFile), true);
$user = $users[$userId];

$feedbacksFile = "../data/feedback/$userId.json";
$feedbacks = file_exists($feedbacksFile) ? json_decode(file_get_contents($feedbacksFile), true) : [];




$total_entries = count($feedbacks) > 0 ? count($feedbacks) : 1;
$totals = [
    "behavior" => 0,
    "intelligence" => 0,
    "friendliness" => 0,
    "emotional" => 0
];

foreach ($feedbacks as $entry) {
    $totals["behavior"] += $entry["behavior"];
    $totals["intelligence"] += $entry["intelligence"];
    $totals["friendliness"] += $entry["friendliness"];
    $totals["emotional"] += $entry["emotional"];
}

$averages = [
    "behavior" => intval($totals["behavior"] / $total_entries),
    "intelligence" => intval($totals["intelligence"] / $total_entries),
    "friendliness" => intval($totals["friendliness"] / $total_entries),
    "emotional" => intval($totals["emotional"] / $total_entries)
];




function printStar(int $num){
    if($num<0 | $num>5){
        return "Undefined";
    }
    $total_stars = 5;
    $output = str_repeat('&#9733;', $num) . str_repeat('&#9734;', $total_stars - $num);
    
    return $output;
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TruthWhisper - Anonymous Feedback App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>

<body class="bg-gray-100">


    <?php require_once './components/header.php' ?>

    
    <div id="full_popup" class="fixed flex min-h-screen w-full flex-col justify-center justify-items-center overflow-hidden backdrop-blur-sm bg-gray-400 bg-opacity-50 z-0" style="top:0; bottom:0;">
        <div class="object-fit w-fit mx-auto bg-white px-10 py-10 rounded-lg">

            <div class="w-full flex justify-end mb-4">
                <div class="me-auto">
                    <span class="text-md font-bold"> Comment: </span>
                </div>
                <div class="cursor-pointer" onclick="closePopup()">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>

            <div class="max-w-80 max-h-80 overflow-y-auto" id="full_feedback">
                Full Feedback here.
            </div>
        </div>
    </div>



    <main class="">
        <div class="relative flex min-h-screen overflow-hidden bg-gray-50 py-6 sm:py-12">
            <img src="./images/beams.jpg" alt="" class="absolute top-1/2 left-1/2 max-w-none -translate-x-1/2 -translate-y-1/2" width="1308" />
            <div class="absolute inset-0 bg-[url(./images/grid.svg)] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>

            <div class="relative max-w-7xl mx-auto">
                <div class="flex justify-end">
                    <span class="block text-gray-600 font-mono border border-gray-400 rounded-xl px-2 py-1">Your feedback form link: <strong>
                            <a href="<?php echo  $uniq_url ?>">
                                <?php
                                $maxLength = 30;
                                if (strlen($uniq_url) > $maxLength) {
                                    echo substr_replace($uniq_url, '...', $maxLength);
                                } else {
                                    echo $uniq_url;
                                }
                                ?>
                            </a>
                        </strong></span>
                    <span id="copyText" class="ms-5 cursor-pointer font-semibold hover:text-indigo-800" onclick="copyLink()">Copy</span>
                    <script>
                        function copyLink() {
                            navigator.clipboard.writeText("<?= $uniq_url ?>");
                            document.querySelector("#copyText").innerText = "Copied";
                        }
                    </script>
                </div>

                <div class="">
                    <?php displayFlashMessage(); ?>
                </div>

                <div class="my-10">
                    <h1 class="text-xl text-indigo-800 text-bold my-3">How you are to others:</h1>

                    <div class="w-full grid grid-cols-4 gap-4">
                        <div class="grid grid-cols-2 bg-white rounded-lg p-5">
                            <div> Behavior: </div>
                            <div class="flex justify-end text-indigo-800"> <?= printStar($averages["behavior"]) ?> </div>
                        </div>
                        <div class="grid grid-cols-2 bg-white rounded-lg p-5">
                            <div> Intelligence: </div>
                            <div class="flex justify-end text-indigo-800"> <?= printStar($averages["intelligence"]) ?> </div>
                        </div>
                        <div class="grid grid-cols-2 bg-white rounded-lg p-5">
                            <div> Friendliness: </div>
                            <div class="flex justify-end text-indigo-800"> <?= printStar($averages["friendliness"]) ?> </div>
                        </div>
                        <div class="grid grid-cols-2 bg-white rounded-lg p-5">
                            <div> Emotional Control: </div>
                            <div class="flex justify-end text-indigo-800"> <?= printStar($averages["emotional"]) ?> </div>
                        </div>
    
                    </div>
                </div>

                <h1 class="text-xl text-indigo-800 text-bold my-3">Received feedback</h1>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <?php if(count($feedbacks)): ?>
                    <?php foreach ($feedbacks as $feedback) : ?>
                        <div class="relative grid grid-cols-1  rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400 cursor-pointer" onclick="showPopup(` <?= $feedback['comment'] ?> `)">
                            <div class=" focus:outline-none">
                                <p class="text-gray-500">
                                    <?= strlen($feedback['comment']) > 300 ? substr($feedback['comment'], 0, 300) . '...' : $feedback['comment']; ?>
                                </p>
                            </div>

                            <div class="my-3 content-end">
                                <div class="grid grid-cols-2">
                                    <div> Behavior: </div>
                                    <div> <?= printStar($feedback['behavior']) ?> </div>
                                </div>

                                <div class="grid grid-cols-2">
                                    <div> Intelligence: </div>
                                    <div> <?= printStar($feedback['intelligence']) ?> </div>
                                </div>

                                <div class="grid grid-cols-2">
                                    <div> Friendliness: </div>
                                    <div> <?= printStar($feedback['friendliness']) ?> </div>
                                </div>

                                <div class="grid grid-cols-2">
                                    <div> Emotional Control: </div>
                                    <div> <?= printStar($feedback['emotional']) ?> </div>
                                </div>

                            </div>

                        </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <span class="block font-bold text-xl text-gray-400">
                            No Feedback Found!
                        </span>
                    <?php endif ?>

                    <script>
                        function showPopup(string) {
                            document.getElementById("full_feedback").innerText = string;
                            document.getElementById("full_popup").classList.remove("z-0");
                            document.getElementById("full_popup").classList.add("z-50");
                        }

                        function closePopup() {
                            document.getElementById("full_popup").classList.remove("z-50");
                            document.getElementById("full_popup").classList.add("z-0");
                            document.getElementById("full_feedback").innerText = "Full Feedback Here";
                        }
                    </script>

                </div>
            </div>

        </div>
    </main>

    <footer class="relative bg-white z-10">
        <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center justify-center lg:px-8">
            <p class="text-center text-xs leading-5 text-gray-500">&copy; 2024 TruthWhisper, Inc. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>