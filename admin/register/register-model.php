<?php



// Admin Page
    $fields = get_option( 'fpb_reg_form_fields', [
        ['type'=>'username','label'=>'Username'],
        ['type'=>'email','label'=>'Email'],
        ['type'=>'password','label'=>'Password'],
        ['type'=>'firstname','label'=>'First Name'],
        ['type'=>'lastname','label'=>'Last Name'],
        ['type'=>'phonenumber','label'=>'Phone Number'],
        ['type'=>'address','label'=>'Address'],
        ['type'=>'city','label'=>'City'],
        ['type'=>'state','label'=>'State'],
        ['type'=>'zipcode','label'=>'Zip Code'],
        ['type'=>'country','label'=>'Country'],
    ]);
    ?>
    <style>
    /* Professional Form Builder CSS */
    .wrap {
        max-width: 800px;
        margin: 30px auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.08);
        padding: 32px 40px;
        font-family: 'Segoe UI', Arial, sans-serif;
    }
    .wrap h1 {
        font-size: 2rem;
        margin-bottom: 18px;
        color: #222;
        font-weight: 600;
    }
    #field-palette {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 18px 16px;
        margin-bottom: 28px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    #field-palette h2 {
        font-size: 1.1rem;
        margin-bottom: 12px;
        color: #444;
    }
    .fpb-palette-btn {
        background: linear-gradient(90deg,#0073e6 60%,#005bb5 100%);
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 8px 18px;
        margin: 0 8px 8px 0;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.2s;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }
    .fpb-palette-btn:hover {
        background: linear-gradient(90deg,#005bb5 60%,#0073e6 100%);
    }
    #fpb-fields-list {
        margin-top: 18px;
        padding: 0;
    }
    .fpb-field-item {
        background: #f4f7fb;
        border: 1px solid #dbe6f3;
        border-radius: 7px;
        margin-bottom: 10px;
        padding: 12px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.04);
        transition: box-shadow 0.2s;
    }
    .fpb-field-item:hover {
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }
    .fpb-field-handle {
        font-size: 1.3rem;
        color: #0073e6;
        cursor: grab;
        margin-right: 10px;
    }
    .fpb-field-label {
        flex: 1;
        font-size: 1.05rem;
        color: #222;
        font-weight: 500;
    }
    .fpb-remove-field {
        background: #e53e3e;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        font-size: 1.1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }
    .fpb-remove-field:hover {
        background: #c53030;
    }
    form .button-primary {
        background: linear-gradient(90deg,#0073e6 60%,#005bb5 100%);
        border-radius: 6px;
        border: none;
        font-size: 1.1rem;
        padding: 10px 28px;
        margin-top: 24px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        transition: background 0.2s;
    }

    .fpb-palette-btn.disabled {
    background: #ccc !important;
    cursor: not-allowed;
    opacity: 0.6;
}

.fps_bottom {

        max-width: 800px;
    margin: 30px auto;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.08);
    padding: 32px 40px;
    font-family: 'Segoe UI', Arial, sans-serif;
}


    form .button-primary:hover {
        background: linear-gradient(90deg,#005bb5 60%,#0073e6 100%);
    }
    </style>
    <div class="wrap">
        <h1>Registration Form Builder</h1>
        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <?php wp_nonce_field( 'fpb_save_form', 'fpb_nonce' ); ?>
            <input type="hidden" name="action" value="fpb_save_form">
            <div id="field-palette">
                <h2>Add Field</h2>
                <button type="button" class="fpb-palette-btn" data-type="username">Username</button>
                <button type="button" class="fpb-palette-btn" data-type="email">Email</button>
                <button type="button" class="fpb-palette-btn" data-type="password">Password</button>
                <button type="button" class="fpb-palette-btn" data-type="firstname">First Name</button>
                <button type="button" class="fpb-palette-btn" data-type="lastname">Last Name</button>
                <button type="button" class="fpb-palette-btn" data-type="lastname">Phone</button>
                <button type="button" class="fpb-palette-btn" data-type="address">Address</button>
                <button type="button" class="fpb-palette-btn" data-type="city">City</button>
                <button type="button" class="fpb-palette-btn" data-type="state">State</button>
                <button type="button" class="fpb-palette-btn" data-type="zipcode">Zip Code</button>
                <button type="button" class="fpb-palette-btn" data-type="country">Country</button>
            </div>
            <h2>Form Layout</h2>
            <ul id="fpb-fields-list">
                <?php foreach ( $fields as $index => $fld ) :
                    
                    if(!empty($fld['label'])):
                    ?>
                    <li class="fpb-field-item" data-type="<?php echo esc_attr($fld['type']); ?>">
                        <span class="fpb-field-handle">☰</span>
                        <span class="fpb-field-label"><?php echo esc_html($fld['label']); ?></span>
                        <button type="button" class="fpb-remove-field">✕</button>
                        <input type="hidden" name="fields[<?php echo $index; ?>][type]" value="<?php echo esc_attr($fld['type']); ?>">
                        <input type="hidden" name="fields[<?php echo $index; ?>][label]" value="<?php echo esc_attr($fld['label']); ?>">
                    </li>
                <?php  endif; endforeach; ?>
            </ul>
            <?php submit_button('Save Form'); ?>
        </form>
    </div>
    <div class="fps_bottom">
        <h3>Use This shortcode</h3>
        <p>To display the registration form on your site, use the shortcode:</p>
        <div class="wpuf-shortcode-area">
                <code>[fpb_register_form]</code>
                <button class="button button-dark button-copy" style="background: rgb(0, 0, 0); color: rgb(255, 255, 255);">Copy</button>
            </div>
        <p>Place this shortcode in any post, page, or widget where you want the registration form to appear.</p>
    </div>
    <style>
    #fpb-fields-list, #field-palette { list-style: none; margin: 0; padding: 0; }
    #fpb-fields-list .fpb-field-item {
        margin: 6px 0; padding: 8px; background:#f1f1f1; border:1px solid #ccc;
        display:flex; align-items:center; gap:8px;
    }
    .fpb-field-handle { cursor: move; }
    .fpb-palette-btn { margin-right: 6px; }
    </style>
   <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const list = document.getElementById('fpb-fields-list');
    const fieldButtons = document.querySelectorAll('.fpb-palette-btn');

    // Create a Set to track added fields (by type)
    const addedFields = new Set();

    // Initialize Sortable.js
    Sortable.create(list, { handle: '.fpb-field-handle' });

    // Disable button if field type is already in the list
    function refreshButtons() {
        fieldButtons.forEach(btn => {
            const type = btn.dataset.type;
            btn.disabled = addedFields.has(type);
            btn.classList.toggle('disabled', btn.disabled);
        });
    }

    // Function to add a field to the form
    function addField(type, label) {
        const li = document.createElement('li');
        li.className = 'fpb-field-item';
        li.setAttribute('data-type', type);
        li.innerHTML = `
            <span class="fpb-field-handle">☰</span>
            <span class="fpb-field-label">${label}</span>
            <button type="button" class="fpb-remove-field">✕</button>
            <input type="hidden" name="fields[][type]" value="${type}">
            <input type="hidden" name="fields[][label]" value="${label}">
        `;
        list.appendChild(li);
        addedFields.add(type);
        refreshButtons();
    }

    // Add button click logic
    fieldButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const type = btn.dataset.type;
            const label = btn.textContent.trim();
            if (!addedFields.has(type)) {
                addField(type, label);
            }
        });
    });

    // Remove field logic
    list.addEventListener('click', (e) => {
        if (e.target.matches('.fpb-remove-field')) {
            const item = e.target.closest('.fpb-field-item');
            const type = item.dataset.type;
            item.remove();
            addedFields.delete(type);
            refreshButtons();
        }
    });

    // Initialize from existing fields
    list.querySelectorAll('.fpb-field-item').forEach(item => {
        addedFields.add(item.dataset.type);
    });
    refreshButtons();
});



 jQuery(".wpuf-shortcode-area button.button-copy").on("click", () => {
        const text = jQuery(".wpuf-shortcode-area code").text();
        const button = ".wpuf-shortcode-area button.button-copy";

        navigator.clipboard.writeText(text).then(() => {
            jQuery(button).html("Copied");
            jQuery(button).css("background", "linear-gradient(90deg, #0073e6 60%, #005bb5 100%)");

            setTimeout(() => {
                makeButtonDefault(button);
            }, 2000);
        }, () => {
            jQuery(button).html("Failed!");
            jQuery(button).css("background", "#600dc8");

            setTimeout(() => {
                makeButtonDefault(button);
            }, 2000);
        });
    });
    
</script>

    <?php