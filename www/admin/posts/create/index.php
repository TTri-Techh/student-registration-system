<?php
require '../../../../vendor/autoload.php';
include '../../../../autoload.php';

use controllers\PostController;

$result = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_btn'])) {
    $data = [
        'title' => $_POST['title'],
        'description' => $_POST['description']
    ];
    $images = $_FILES['images'];
    $postController = new PostController();
    $result = $postController->createPost($data, $images);
    if ($result == true) {
        header("Location: ../");
    }
}

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

                <div class="m-4">
                    <button
                        onclick="history.back()"
                        class="px-4 py-2 my-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        &larr;
                    </button>
                    <h3
                        class="mb-4 text-2xl font-semibold text-gray-800 dark:text-gray-300">Create a new post</h3>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Title</span>
                            <input name="title" required
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                placeholder="Title" />
                        </label>

                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Description</span>
                            <textarea
                                name="description" required
                                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                rows="10"
                                placeholder="Write content here."></textarea>
                        </label>

                        <label class="block mt-4 text-sm" for="images">Images
                            <input name="images[]" id="images" type="file" multiple class=" w-full mt-3 cursor-pointer bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded-lg outline-none border border-gray-200 focus:border-indigo-600 dark:border-gray-800 dark:focus:border-indigo-600 focus:ring-0 file:bg-indigo-600 file:text-white file:border-none file:rounded-l-lg file:py-2 file:px-4 file:mr-3 file:cursor-pointer">
                        </label>

                        <button
                            name="post_btn"
                            class="px-4 py-2 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Post
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>