<?php
    include("head.inc.php");
    include("header.inc.php");
    include("footer.inc.php");
    include("galleryItem.inc.php");
    require_once("settings.php");
    $conn = @mysqli_connect($host, $user, $password, $sql_db);
?>
<!DOCTYPE html>
<html lang="en">
    <?php
        head_code();
    ?>
    <body>
        <?php
            header_code(0);
        ?>
        <main>
            <div id="container">
                <section>
                    <div id="banner">
                        <div id="banner-images">
                            <img src="public/images/home/banner.webp" alt=""/>
                            <img src="public/images/home/banner2.webp" alt=""/>
                            <img src="public/images/home/banner3.jpg" alt=""/>
                            <img src="public/images/home/colorfulsmoke.jpg" alt=""/>
                            <img src="public/images/home/banner.webp" alt=""/>
                        </div>
                        <h1>The only time you cannot smoke is when you are sleeping!</h1>
                    </div>
                    <div></div>
                </section>
                <section>
                    <div id="introduction">
                        <div id="intro-background">
                            <h2>Welcome to BRUHHH</h2>
                            <img class="divider" src="public/images/divider.png" alt=""/>
                            <div class="intro-desc">
                                <p><i>
                                    Welcome to the premier source for all things vape! Here you'll find everything from beginner basics to advanced tricks and techniques. Whether you're new to vaping or an expert, we have something for everyone.
                                </i></p>
                                <p><i>
                                    We have a wide selection of starter kits, tanks, atomizers, e-juice, mods, and accessories. Plus, with free shipping in the US, our prices can't be beaten!
                                </i></p>
                                <p><i>
                                    Ready to get started? Check out some of our newest products below.
                                </i></p>
                            </div>
                        </div>
                    </div>
                </section>
                <section>
                    <div id="product-list">
                        <div id="list-intro">
                            <h2>Our Products</h2>
                            <img class="divider" src="public/images/divider.png" alt=""/>
                            <p><i>Take a look at some of our most interesting products.</i></p>
                        </div>
                        <div id="sec3">
                            <?php
                                if(!$conn) {
                                    echo "<p>Oops! Something went wrong! :(</p>";
                                } else {
                                    $result = mysqli_query($conn, "SELECT * FROM products ORDER BY pdate DESC LIMIT 9;");
                                    for($i = 0; $i < mysqli_num_rows($result); $i++) {
                                        $id = $i + 1;
                                        if($i == 0) {
                                            echo "<input type='radio' id='page-btn-$id' name='page-btn' checked='checked'/>";
                                        } else {
                                            echo "<input type='radio' id='page-btn-$id' name='page-btn'/>";
                                        }
                                    }
                                }
                                if(mysqli_num_rows($result) > 0) {
                                    $rowIndex = 1;
                                    $pageIndex = 1;
                                    $rowLast = false;
                                    while($row = mysqli_fetch_assoc($result)) {
                                        if($rowIndex % 3 == 0) {
                                            $rowLast = true;
                                        } else {
                                            $rowLast = false;
                                        }
                                        if($rowIndex % 9 == 1) {
                                            echo "<ul class='item-list page$pageIndex'>";
                                            $pageIndex += 1;
                                        }
                                        galleryItem($rowLast, $row["product_id"],$row["pname"],$row["pdesc"],$row["pprice"],base64_encode($row["pimage"]),$row["pimagetype"]);
                                        if($rowIndex % 9 == 0) {
                                            echo "</ul>";
                                        }
                                        $rowIndex += 1;
                                    }
                                    if($rowIndex % 9 != 0) {
                                        $pageIndex -= 1;
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </section>
                <section>
                    <div id="outtroduction">
                        <h2>Our ambitions</h2>
                        <img class="divider" src="public/images/divider.png" alt=""/>
                        <p><i>We aim to create a world where everyone vapes but still healthy.</i></p>
                    </div>
                </section>
            </div>
        </main>
        <?php
            footer_code();
        ?>
    </body>
</html>