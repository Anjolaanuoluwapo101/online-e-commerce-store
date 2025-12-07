<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">Create Category</h2>
        
        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($errors['general'])): ?>
            <div class="alert alert-danger">
                <p><?= $errors['general'] ?></p>
            </div>
        <?php endif; ?>
        
        <div class="card-admin">
            <div class="card-admin-header">
                <h5><i class="fa fa-folder"></i> Category Details</h5>
            </div>
            <div class="card-admin-body">
                <form method="POST" action="/admin/categories/store">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name *</label>
                        <?php if (isset($errors['name'])): ?>
                            <div class="text-danger"><?= $errors['name'] ?></div>
                        <?php endif; ?>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name ?? '') ?>" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control"><?= htmlspecialchars($description ?? '') ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <button type="submit" class="btn-admin">
                            <i class="fa fa-save"></i> Create Category
                        </button>
                        <a href="/admin/categories" class="btn btn-secondary">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>