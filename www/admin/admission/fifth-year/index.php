<?php


require '../../../../vendor/autoload.php';
include '../../../../autoload.php';

use controllers\AcademicYearController;
use controllers\StudentAdmissionController;

$status = 0;

session_start();

$academicYearController = new AcademicYearController();
$academicYears = $academicYearController->index();
$selectedYear = getYear($academicYears[0]['academic_year']);
$status = $_SESSION['status'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['status'] = $_POST['status'];
    // $status = $_POST['status'];
    $selectedYear = getYear($_POST['selected_year']);

    // Redirect to the same page to apply the session changes immediately
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

function getYear($year)
{
    $part = explode('-', $year);
    return $part[0];
}
// Pagination Logic
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10;

$studentAdmissionController = new StudentAdmissionController();
$freshers = $studentAdmissionController->getAllStudentsByStatusAndYear($status, 5, $selectedYear, $page, $limit);
$getStudentsTotalRows = $studentAdmissionController->getTotalRows(5, $status);
$totalPages = ceil($getStudentsTotalRows / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<?php
include("../../../utils/components/admin/admin.links.php");
?>

<body>
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
        <!-- Sidebar -->
        <?php
        include("../../../utils/components/admin/admin.sidebar.php");
        ?>
        <!-- Main content -->
        <div class=" flex flex-col flex-1 md:ml-64">
            <!-- Navbar -->
            <?php
            include("../../../utils/components/admin/admin.navigation.php");
            ?>
            <!-- Scrollable content section -->
            <div class="overflow-y-auto md:pt-16 px-4 pb-4 h-full">

                <div class="p-4">
                    <div class="flex justify-between items-start mb-4">
                        <button onclick="window.location.href='../'"
                            class="px-4 py-2 my-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            &larr;
                        </button>
                        <h4 class="m-4 text-2xl font-semibold text-gray-800 dark:text-gray-300">
                            ပဥ္စမနှစ်ဝင်ခွင့်လျှောက်ထားသူများ
                        </h4>
                        <form action="" method="POST">
                            <select id="status" name="status" onchange="this.form.submit()"
                                class="form-input mt-3 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-indigo-600 dark:border-gray-800 dark:focus:border-indigo-600 focus:ring-0">
                                <option value="0" <?php if ($status == 0)
                                                        echo 'selected'; ?>>
                                    အတည်မပြုရသေးသောလျှောက်လွှာများ</option>
                                <option value="1" <?php if ($status == 1)
                                                        echo 'selected'; ?>>
                                    အတည်ပြုပြီးသောလျှောက်လွှာများ</option>
                            </select>
                            <select id="selected_year" name="selected_year" onchange="this.form.submit()"
                                class="form-input mt-3 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-indigo-600 dark:border-gray-800 dark:focus:border-indigo-600 focus:ring-0">
                                <?php foreach ($academicYears as $year): ?>
                                    <option value="<?= $year["academic_year"] ?>" <?php if ($selectedYear == getYear($year['academic_year']))
                                                                                        echo 'selected' ?>>
                                        <?= $year['academic_year'] . " (ပညာသင်နှစ်)" ?>
                                    </option>
                                <?php endforeach ?>

                            </select>
                        </form>


                    </div>
                    <!-- New Table -->
                    <div class=" w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full ">
                            <table class="table-fixed w-full whitespace-no-wrap">
                                <thead>
                                    <tr class="text-xs font-semibold tracking-wide text-left  uppercase border-b ">
                                        <th class="px-4 py-3">စဉ်</th>
                                        <th class="px-4 py-3">ဝင်ခွင့်အမှတ်စဉ်</th>
                                        <th class="px-4 py-3">အမည်</th>
                                        <th class="px-4 py-3">မှတ်ပုံတင်အမှတ်</th>
                                        <th class="px-4 py-3">စစ်ဆေးရန်</th>

                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                    <?php
                                    $count = 1;
                                    foreach ($freshers as $fresher) {
                                        $id = $fresher['id'];

                                    ?>
                                        <tr class="text-gray-700 dark:text-gray-400">
                                            <td class="px-4 py-3">
                                                <?= $count ?>
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <?= $fresher['matriculation_reg_num'] ?>
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <?= $fresher['student_name_my'] ?>
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <?= $fresher['student_nrc'] ?>
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <?php if ($status == 1): ?>
                                                    <a href="view.php?id=<?= $fresher['id'] ?>"
                                                        class="text-indigo-700 hover:text-indigo-400">အသေးစိတ်ကြည့်ရှုရန်</a>
                                                <?php else: ?>
                                                    <a href="update.php?id=<?= $fresher['id'] ?>"
                                                        class="text-indigo-700 hover:text-indigo-400">စစ်ဆေးကြည့်ရှုရန်</a>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                    <?php $count++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <span class="flex items-center col-span-3"></span>
                        <span class="col-span-2"></span>
                        <!-- Pagination -->
                        <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                            <nav aria-label="Table navigation">
                                <ul class="inline-flex items-center">
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li>
                                            <a href="?page=<?= $i; ?>"
                                                class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple transition-colors duration-150 <?= ($i == $page) ? 'bg-purple-600 text-white' : 'text-gray-700'; ?>">
                                                <?= $i; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        </span>
                    </div>
                </div>


            </div>
</body>

<script src=" ../../../../utils/assets/js/alertify.js"></script>
<script>
    <?php
    if ($_SESSION['isApproved'] === false) {
        echo "alertify.warning('အတည်ပြုခြင်းမအောင်မြင်ပါ။');";
    } elseif ($_SESSION['isApproved'] == null) {
        return;
    } elseif (isset($_SESSION['isApproved'])) {
        echo "alertify.success('အတည်ပြုပြီးပါပြီ။');";
    }

    // Unset all of the session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();
    ?>
</script>

</html>