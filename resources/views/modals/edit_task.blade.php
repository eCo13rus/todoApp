<!-- Модальное окно для задачи -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="taskModalLabel">Редактирование задачи</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Форма редактирования задачи -->
        <form id="editTaskForm">
          <input type="hidden" id="editTaskId">
          <div class="mb-3 text-start">
            <label for="editTaskName" class="form-label">Создал:</label>
            <input type="text" class="form-control" id="editTaskName">
          </div>
          <div class="mb-3 text-start">
            <label for="editTaskTitle" class="form-label">Кому:</label>
            <input type="text" class="form-control" id="editTaskTitle">
          </div>
          <div class="mb-3 text-start">
            <label for="editTaskDescription" class="form-label">Описание:</label>
            <textarea class="form-control" id="editTaskDescription"></textarea>
          </div>
          <div class="d-flex justify-content-start">
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            <button type="button" class="btn btn-danger ms-4" id="deleteTaskButton">Удалить задачу</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>