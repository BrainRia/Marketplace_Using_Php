<div id="itemModal" class="modal">
    <div class="modal-box modern">

        <form id="itemForm" enctype="multipart/form-data">

    <!-- IMAGE -->
    <label>Item Photo</label>
    <label class="upload-box">
    Click to add photo
    <input type="file" name="image" accept="image/*" hidden>
</label>


    <!-- TITLE -->
    <label>Item Title *</label>
    <input type="text" name="title" placeholder="e.g. Calculus Textbook - 11th Edition" required>

    <!-- DESCRIPTION -->
    <label>Description *</label>
    <textarea name="description" placeholder="Describe the condition, features, and any important details..." required></textarea>

    <!-- ROW 1 -->
    <div class="grid-2">
        <div>
            <label>Price (€) *</label>
            <input type="number" name="price" step="0.01" placeholder="0.00" required>
        </div>

        <div>
                    <label>Category *</label>
                    <select name="category_id" required>
                        <option value="">Select category</option>
                        <?php
                        $cats = $conn->query("SELECT id, name FROM categories");
                        while ($c = $cats->fetch_assoc()):
                        ?>
                            <option value="<?= $c['id'] ?>">
                                <?= htmlspecialchars($c['name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
    </div>

    <!-- ROW 2 -->
    <div class="grid-2">
        <div>
            <label>Condition *</label>
            <select name="item_condition" required>
                <option value="">Select condition</option>
                <option>New</option>
                <option>Like New</option>
                <option>Used</option>
            </select>
        </div>

        <div>
            <label>Pickup Location *</label>
            <input type="text" name="pickup_location" placeholder="e.g. Central Campus" required>
        </div>
    </div>

    <!-- WEIGHT -->
    <label>Weight (kg) *</label>
    <input type="number" name="weight_kg" step="0.01" placeholder="e.g. 2.5" required>

    <!-- ACTIONS -->
    <div class="modal-actions">
        <button type="button" class="secondary" id="closeModal">Cancel</button>
        <button type="submit" class="primary">List Item</button>
    </div>

        </form>

    </div>
</div>
