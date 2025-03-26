<?php if (isset($_SESSION['Owner_ID'])): ?>
                            <div class="profile-button">
                                <p class=" fa fa-user" style="margin: 10px" onclick="toggloeMenu()">
                                    <?php echo $_SESSION['Username_Owner']; ?>
                                </p>
                            </div>
                            <div class="sub-menu-wrap" id="subMenu">
                                <div class="sub-menu">
                                    <div class="user-info">
                                        <img src="Picture/Sihba_07.jpg">
                                        <h2><?php echo $_SESSION['Username_Owner']; ?></h2>
                                        <h3>ID:<?php echo $_SESSION['Owner_ID']; ?></h3>
                                    </div>

                                    <hr>

                                    <a href="logout.php" class="sub-menu-link">
                                        <img src="images/profile.png">
                                        <p>ออกจากระบบ</p>
                                        <span></span>
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <a role="button" tabindex="0" href="login.php" class="login-button btn btn-primary">
                                <span>เข้าสู่ระบบ</span>
                            </a>
                            <a role="button" tabindex="0" href="registration.php" class="login-button btn btn-primary">
                                <span>สมัครสมาชิก</span>
                            </a>
                        <?php endif; ?>