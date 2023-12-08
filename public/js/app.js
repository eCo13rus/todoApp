// Генерация HTML Карточек
function createTaskCard(task) {
  return `
    <div class="col-md-3 text-start">
      <div class="card mb-5 ms-4" style="width: 15rem; height: 200px" data-task-id="${task.id}">
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><strong>Создал:</strong> ${task.name}</li>
          <li class="list-group-item"><strong>Кому:</strong> ${task.title}</li>
          <li class="list-group-item" data-full-description="${task.description}"><strong>Описание:</strong> ${task.short_description}</li>
        </ul>
      </div>
    </div>`;
}


// Добавление задачи
$(document).ready(function () {
  $('#createTaskForm').on('submit', function (e) {
    e.preventDefault();

    // Получение значений из формы
    const creatorName = $('#creatorName').val();
    const taskName = $('#taskName').val();
    const taskDescription = $('#taskDescription').val();

    // AJAX запрос
    $.ajax({
      type: 'POST',
      url: '/tasks',
      data: {
        name: creatorName,
        title: taskName,
        description: taskDescription,
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (task) {
        // Добавление новой задачи в контейнер задач
        $('#tasksContainer').append(createTaskCard(task));

        // Сброс формы и закрытие модального окна
        $('#createTaskForm')[0].reset();
        $('#createTaskModal').modal('hide');
      }
    });
  });
});



// Обработка отправки формы редактирования
$(document).ready(function () {
  $('#editTaskForm').on('submit', function (e) {
    e.preventDefault();

    const taskId = $('#editTaskId').val();
    const taskName = $('#editTaskName').val();
    const taskTitle = $('#editTaskTitle').val();
    const taskDescription = $('#editTaskDescription').val();

    // AJAX запрос для обновления задачи
    const taskElement = $(`[data-task-id="${taskId}"]`);
    $.ajax({
      type: 'POST',
      url: `/tasks/${taskId}`,
      data: {
        _method: 'PUT',
        name: taskName,
        title: taskTitle,
        description: taskDescription,
        _token: $('meta[name="csrf-token"]').attr('content')
      },

      success: function (task) {
        taskElement.replaceWith(createTaskCard(task));

        // Закрытие модального окна
        $('#taskModal').modal('hide');
      },
      error: function (xhr, status, error) {
        console.error('Ошибка обновления: ' + error);
      }
    });
  });
});



// Отправка запроса на удаление задачи
document.getElementById('deleteTaskButton').addEventListener('click', function () {
  const taskId = document.getElementById('editTaskId').value;

  fetch(`/tasks/${taskId}`, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Content-Type': 'application/json'
    }
  })
    .then(response => {
      if (!response.ok) {
        throw new Error(`Ошибка запроса: ${response.statusText}`);
      }
      return response.json();
    })
    .then(data => {
      console.log(data);
      const taskColumn = document.querySelector(`[data-task-id="${taskId}"]`).parentNode;
      if (taskColumn) {
        taskColumn.remove();
      }
      const taskModal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
      taskModal.hide();
    })
    .catch(error => console.error('Ошибка:', error));
});




// Уведомление о входе
document.addEventListener("DOMContentLoaded", function () {
  setTimeout(function () {
    $(".alert-primary").slideUp(600);
  }, 2000);
});




// Обработка кликов
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('tasksContainer').addEventListener('click', function (event) {
    const card = event.target.closest('.card');
    if (card) {
      var taskId = card.getAttribute('data-task-id');
      var taskName = card.querySelector('li:nth-child(1)').textContent.replace('Создал: ', '');
      var taskTitle = card.querySelector('li:nth-child(2)').textContent.replace('Кому: ', '');
      var taskDescription = card.querySelector('li:nth-child(3)').getAttribute('data-full-description');

      document.getElementById('editTaskId').value = taskId;
      document.getElementById('editTaskName').value = taskName;
      document.getElementById('editTaskTitle').value = taskTitle;
      document.getElementById('editTaskDescription').value = taskDescription;

      var taskModal = new bootstrap.Modal(document.getElementById('taskModal'));
      taskModal.show();
    }
  });
});



// чтения данных из data-tasks
document.addEventListener('DOMContentLoaded', function() {
  var tasksContainer = document.getElementById('tasksContainer');
  var tasks = JSON.parse(tasksContainer.getAttribute('data-tasks'));

  tasks.forEach(function(task) {
    $('#tasksContainer').append(createTaskCard(task));
  });
});
