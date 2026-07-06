<?php include 'includes/header.php'; ?>

<div class="container">
    <div class="card">
        <h2>⚕️ How Our Matching System Works</h2>

        <p style="color:var(--muted); margin-bottom:30px; font-size:15px;">
            Our system uses a <strong>rule-based compatibility matching algorithm</strong> to automatically
            identify suitable kidney donor-recipient pairs based on predefined medical criteria.
        </p>

        <!-- Step cards -->
        <div style="display:grid; grid-template-columns:repeat(2,1fr); gap:20px; margin-bottom:36px;">

            <div style="background:var(--teal-light); border-radius:12px; padding:24px;">
                <div style="font-size:32px; margin-bottom:12px;">🩸</div>
                <h3 style="color:var(--teal-dark); margin-bottom:8px;">Step 1 — Register Donor</h3>
                <p style="color:var(--muted); font-size:13.5px;">A donor registers with their full name, age, blood group, health status, and contact details. The system stores this securely in the database.</p>
            </div>

            <div style="background:var(--teal-light); border-radius:12px; padding:24px;">
                <div style="font-size:32px; margin-bottom:12px;">🏥</div>
                <h3 style="color:var(--teal-dark); margin-bottom:8px;">Step 2 — Register Recipient</h3>
                <p style="color:var(--muted); font-size:13.5px;">A recipient registers with their medical details and urgency level (High / Medium / Low). They are automatically added to the waiting list.</p>
            </div>

            <div style="background:var(--teal-light); border-radius:12px; padding:24px;">
                <div style="font-size:32px; margin-bottom:12px;">🔗</div>
                <h3 style="color:var(--teal-dark); margin-bottom:8px;">Step 3 — Auto Matching</h3>
                <p style="color:var(--muted); font-size:13.5px;">The matching algorithm runs automatically and checks all four compatibility conditions simultaneously for every registration.</p>
            </div>

            <div style="background:var(--teal-light); border-radius:12px; padding:24px;">
                <div style="font-size:32px; margin-bottom:12px;">✅</div>
                <h3 style="color:var(--teal-dark); margin-bottom:8px;">Step 4 — Match Confirmed</h3>
                <p style="color:var(--muted); font-size:13.5px;">When a match is found, it is recorded in the database, the recipient's status is updated to "Matched", and they are removed from the waiting list.</p>
            </div>

        </div>

        <!-- Matching Rules -->
        <h3 style="color:var(--teal-dark); margin-bottom:16px; font-size:18px;">🧬 Compatibility Rules</h3>
        <p style="color:var(--muted); margin-bottom:20px; font-size:14px;">All four conditions must be satisfied simultaneously for a match to be identified:</p>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Criterion</th>
                    <th>Rule</th>
                    <th>Condition</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>🩸 Blood Group</td>
                    <td>Donor and recipient blood group must match</td>
                    <td><span class="badge badge-matched">Exact Match</span></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>👤 Age Difference</td>
                    <td>Age gap between donor and recipient</td>
                    <td><span class="badge badge-medium">≤ 15 Years</span></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>💊 Donor Health</td>
                    <td>Donor must be in good health</td>
                    <td><span class="badge badge-matched">Healthy</span></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>📋 Recipient Status</td>
                    <td>Recipient must be actively waiting</td>
                    <td><span class="badge badge-waiting">Waiting</span></td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top:30px; text-align:center;">
            <a href="donor/register.php" class="btn btn-primary">🩸 Register as Donor</a>
            &nbsp;&nbsp;
            <a href="recipient/register.php" class="btn btn-success">🏥 Register as Recipient</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>