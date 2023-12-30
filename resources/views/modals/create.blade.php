<!-- Модальное окно для добавления задачи -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createTaskModalLabel">Новая задача</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="createTaskForm">
          <div class="mb-3 text-start">
            <label for="creatorName" class="form-label">Создал:</label>
            <input type="text" class="form-control" id="creatorName" name="name" required>
          </div>
          <div class="mb-3 text-start">
            <label for="taskName" class="form-label">Кому:</label>
            <input type="text" class="form-control" id="taskName" name="title" required>
          </div>
          <div class="mb-3 text-start">
            <label for="taskDescription" class="form-label">Описание задачи:</label>
            <textarea class="form-control" id="taskDescription" name="description" rows="5" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Добавить задачу</button>
        </form>
      </div>
    </div>
  </div>
</div>