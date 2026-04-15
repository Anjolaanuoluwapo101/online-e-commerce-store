<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">Edit Tag</h2>
        
        <?php if (isset($errors['general'])): ?>
            <div class="alert alert-danger">
                <p><?= $errors['general'] ?></p>
            </div>
        <?php endif; ?>
        
        <div class="card-admin">
            <div class="card-admin-header">
                <h5><i class="fa fa-tag"></i> Tag Details</h5>
            </div>
            <div class="card-admin-body">
                <form method="POST" action="/admin/tags/<?= $tag['id'] ?>/update">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name *</label>
                        <?php if (isset($errors['name'])): ?>
                            <div class="text-danger"><?= $errors['name'] ?></div>
                        <?php endif; ?>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($tag['name']) ?>" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control"><?= htmlspecialchars($tag['description'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <button type="submit" class="btn-admin">
                            <i class="fa fa-save"></i> Update Tag
                        </button>
                        <a href="/admin/tags" class="btn btn-secondary">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>