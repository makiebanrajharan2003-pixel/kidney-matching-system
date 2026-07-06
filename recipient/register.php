<?php include '../includes/header.php'; ?>

<div class="container">
    <div class="card">
        <h2>🏥 Recipient Registration</h2>

        <?php
        if (isset($_GET['matched'])) {
            echo '
            <div style="background:linear-gradient(135deg,#E8F5E9,#C8E6C9);
                        border-left:4px solid #2E9E5E;
                        border-radius:10px;
                        padding:20px 24px;
                        margin-bottom:24px;">
                <h3 style="color:#1B5E20; margin-bottom:8px;">🎉 Congratulations, ' . htmlspecialchars($_GET['name']) . '!</h3>
                <p style="color:#2E7D32; font-size:14px; margin-bottom:6px;">
                    A compatible kidney donor has been found for you!
                </p>
                <p style="color:#388E3C; font-size:13px;">
                    ✅ Blood Group: <strong>' . htmlspecialchars($_GET['blood']) . '</strong><br>
                    ✅ Your transplant coordinator will contact you shortly.<br>
                    ✅ Please check the <a href="../matching/match_engine.php" style="color:#1B5E20;font-weight:600;">Match Results</a> page for details.
                </p>
            </div>';
        }

        if (isset($_GET['waiting'])) {
            echo '
            <div style="background:linear-gradient(135deg,#FFF8E1,#FFECB3);
                        border-left:4px solid #F9A825;
                        border-radius:10px;
                        padding:20px 24px;
                        margin-bottom:24px;">
                <h3 style="color:#E65100; margin-bottom:8px;">⏳ Registered Successfully, ' . htmlspecialchars($_GET['name']) . '!</h3>
                <p style="color:#BF360C; font-size:14px; margin-bottom:6px;">
                    No compatible donor is available at this moment.
                </p>
                <p style="color:#E64A19; font-size:13px;">
                    📋 Blood Group Required: <strong>' . htmlspecialchars($_GET['blood']) . '</strong><br>
                    📋 Urgency Level: <strong>' . htmlspecialchars($_GET['urgency']) . '</strong><br>
                    📋 You have been added to the
                    <a href="../waiting_list/view.php" style="color:#BF360C;font-weight:600;">Waiting List</a>.<br>
                    📋 You will be matched automatically when a compatible donor registers.
                </p>
            </div>';
        }

        if (isset($_GET['error'])) {
            echo '<div class="alert alert-error">❌ ' . htmlspecialchars($_GET['error']) . '</div>';
        }
        ?>

        <!-- ══════════════════════════════
             STEP 1: CHECK AVAILABILITY
        ══════════════════════════════ -->
        <div id="step1" style="margin-bottom:30px;">

            <div style="background:var(--teal-light); border-radius:12px; padding:24px; margin-bottom:20px;">
                <h3 style="color:var(--teal-dark); margin-bottom:6px; font-size:17px;">
                    🔍 Step 1 — Check Donor Availability
                </h3>
                <p style="color:var(--muted); font-size:13.5px; margin-bottom:16px;">
                    Enter your blood group to check how many compatible donors are currently available.
                </p>

                <div style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;">
                    <div style="flex:1; min-width:180px;">
                        <label style="display:block; font-weight:600; margin-bottom:7px; font-size:13.5px; color:var(--text);">
                            Your Blood Group
                        </label>
                        <select id="check_blood_group" style="width:100%; padding:12px 16px; border:2px solid #E8EAE9; border-radius:10px; font-size:14.5px; font-family:'Poppins',sans-serif; outline:none;">
                            <option value="">-- Select Blood Group --</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                    <button onclick="checkAvailability()"
                        style="padding:12px 28px; background:linear-gradient(135deg,var(--teal),var(--teal-dark));
                               color:white; border:none; border-radius:10px; font-size:14.5px;
                               font-weight:600; font-family:'Poppins',sans-serif; cursor:pointer;
                               box-shadow:0 4px 14px rgba(11,110,92,0.3);">
                        🔍 Check Now
                    </button>
                </div>

                <!-- Result Box -->
                <div id="availability-result" style="display:none; margin-top:20px; border-radius:10px; padding:16px 20px;">
                </div>
            </div>

        </div>

        <!-- ══════════════════════════════
             STEP 2: REGISTER FORM
        ══════════════════════════════ -->
        <div id="step2" style="display:none;">

            <div style="border-top:2px solid var(--teal-light); padding-top:24px; margin-bottom:20px;">
                <h3 style="color:var(--teal-dark); font-size:17px; margin-bottom:6px;">
                    📋 Step 2 — Complete Your Registration
                </h3>
                <p style="color:var(--muted); font-size:13.5px;">
                    Fill in your details below to register and get matched automatically.
                </p>
            </div>

            <form action="recipient_process.php" method="POST">

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" placeholder="Enter full name" required>
                </div>

                <div class="form-group">
                    <label>Age</label>
                    <input type="number" name="age" placeholder="Enter age" min="1" max="70" required>
                </div>

                <div class="form-group">
                    <label>Blood Group</label>
                    <select name="blood_group" id="form_blood_group" required>
                        <option value="">-- Select Blood Group --</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Urgency Level</label>
                    <select name="urgency_level" required>
                        <option value="">-- Select Urgency Level --</option>
                        <option value="High">High (Immediate need)</option>
                        <option value="Medium">Medium (Can wait)</option>
                        <option value="Low">Low (Stable condition)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter email address" required>
                </div>

                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" name="contact_number" placeholder="Enter contact number" required>
                </div>

                <button type="submit" class="btn btn-success">
                    ✅ Register as Recipient
                </button>

            </form>
        </div>

    </div>
</div>

<!-- JavaScript -->
<script>
function checkAvailability() {
    const blood = document.getElementById('check_blood_group').value;
    const resultBox = document.getElementById('availability-result');
    const step2 = document.getElementById('step2');

    if (!blood) {
        resultBox.style.display = 'block';
        resultBox.style.background = '#FFEBEE';
        resultBox.style.borderLeft = '4px solid #E05444';
        resultBox.innerHTML = '❌ Please select your blood group first!';
        return;
    }

    // AJAX call to check availability
    fetch('../matching/check_availability.php?blood_group=' + encodeURIComponent(blood))
        .then(res => res.json())
        .then(data => {
            resultBox.style.display = 'block';

            if (data.count > 0) {
                resultBox.style.background = 'linear-gradient(135deg,#E8F5E9,#C8E6C9)';
                resultBox.style.borderLeft = '4px solid #2E9E5E';
                resultBox.innerHTML = `
                    <h4 style="color:#1B5E20; margin-bottom:6px;">
                        ✅ ${data.count} Compatible Donor(s) Available!
                    </h4>
                    <p style="color:#2E7D32; font-size:13.5px; margin-bottom:12px;">
                        Great news! There are <strong>${data.count}</strong> healthy donor(s)
                        with blood group <strong>${blood}</strong> currently available.
                        Register now to get matched immediately!
                    </p>
                    <button onclick="showRegistrationForm('${blood}')"
                        style="padding:10px 24px; background:linear-gradient(135deg,#2E9E5E,#1E7A46);
                               color:white; border:none; border-radius:8px; font-size:14px;
                               font-weight:600; font-family:'Poppins',sans-serif; cursor:pointer;">
                        📋 Proceed to Register →
                    </button>
                `;
            } else {
                resultBox.style.background = 'linear-gradient(135deg,#FFF8E1,#FFECB3)';
                resultBox.style.borderLeft = '4px solid #F9A825';
                resultBox.innerHTML = `
                    <h4 style="color:#E65100; margin-bottom:6px;">
                        ⏳ No Donors Available Right Now
                    </h4>
                    <p style="color:#BF360C; font-size:13.5px; margin-bottom:12px;">
                        Currently, no compatible donors with blood group
                        <strong>${blood}</strong> are available.
                        You can still register — you will be added to the waiting list
                        and matched automatically when a donor registers.
                    </p>
                    <button onclick="showRegistrationForm('${blood}')"
                        style="padding:10px 24px; background:linear-gradient(135deg,#E65100,#BF360C);
                               color:white; border:none; border-radius:8px; font-size:14px;
                               font-weight:600; font-family:'Poppins',sans-serif; cursor:pointer;">
                        📋 Register & Join Waiting List →
                    </button>
                `;
            }
        })
        .catch(() => {
            resultBox.style.display = 'block';
            resultBox.style.background = '#FFEBEE';
            resultBox.style.borderLeft = '4px solid #E05444';
            resultBox.innerHTML = '❌ Error checking availability. Please try again.';
        });
}

function showRegistrationForm(blood) {
    // Show step 2
    document.getElementById('step2').style.display = 'block';

    // Auto-select blood group in form
    document.getElementById('form_blood_group').value = blood;

    // Scroll to form
    document.getElementById('step2').scrollIntoView({ behavior: 'smooth' });
}
</script>

<?php include '../includes/footer.php'; ?>