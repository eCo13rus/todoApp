// Добавление задачи
$(document).ready(function () {
  $('#createTaskForm').on('submit', function (e) {
    e.preventDefault();

    // Получение значений из формы
    var creatorName = $('#creatorName').val();
    var taskName = $('#taskName').val();
    var taskDescription = $('#taskDescription').val();

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
        // Создание HTML карточки
        var newTaskHtml = `<div class="col-md-3 text-center mb-3">
        <div class="card" data-task-id="${task.id}">
          <h3 class="card-name">${task.name}</h3>
          <h5 class="card-header">${task.title}</h5>
            <p class="card-text">${task.description}</p>
        </div>
      </div>`;

        // Добавление в контейнер задач
        $('#tasksContainer').append(newTaskHtml);

        // Закрытие модального окна
        $('#createTaskForm')[0].reset();
        $('#createTaskModal').modal('hide');
      }
    });
  });
});




// Уведомление
document.addEventListener("DOMContentLoaded", function () {
  setTimeout(function () {
    $(".alert-success").slideUp(1000);
  }, 2500);
});


// Обработка кликов
document.addEventListener('DOMContentLoaded', function () {
  // Делегирование событий для кликов на карточках задач
  document.getElementById('tasksContainer').addEventListener('click', function (event) {
    var card = event.target.closest('.card');
    if (card) {
      var taskId = card.getAttribute('data-task-id');
      var taskName = card.querySelector('.card-name').textContent;
      var taskTitle = card.querySelector('.card-header').textContent;
      var taskDescription = card.querySelector('.card-text').textContent;

      // Заполняем форму данными
      document.getElementById('editTaskId').value = taskId;
      document.getElementById('editTaskName').value = taskName;
      document.getElementById('editTaskTitle').value = taskTitle;
      document.getElementById('editTaskDescription').value = taskDescription;

      // Показываем модальное окно
      var taskModal = new bootstrap.Modal(document.getElementById('taskModal'));
      taskModal.show();
    }
  });
});




// Обработка отправки формы редактирования
$(document).ready(function () {
  $('#editTaskForm').on('submit', function (e) {
    e.preventDefault();

    var taskId = $('#editTaskId').val();
    var taskName = $('#editTaskName').val();
    var taskTitle = $('#editTaskTitle').val();
    var taskDescription = $('#editTaskDescription').val();

    // AJAX запрос для обновления задачи
    $.ajax({
      type: 'POST',
      url: '/tasks/' + taskId,
      data: {
        _method: 'PUT', // Для поддержки PUT запроса в Laravel через форму
        name: taskName,
        title: taskTitle,
        description: taskDescription,
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (task) {
        // Находим карточку с нужным data-task-id
        var cardToUpdate = $(`[data-task-id="${task.id}"]`);

        // Обновляем содержимое карточки
        cardToUpdate.find('.card-name').text(task.name);
        cardToUpdate.find('.card-header').text(task.title);
        cardToUpdate.find('.card-text').text(task.description);

        // Закрытие модального окна
        $('#taskModal').modal('hide');
      },
      error: function (xhr, status, error) {
        // Обработка ошибок
        console.error('Ошибка обновления: ' + error);
      }
    });
  });
});








// Отправка запроса на удаление задачи
document.getElementById('deleteTaskButton').addEventListener('click', function () {
  var taskId = document.getElementById('editTaskId').value;

  fetch('/tasks/' + taskId, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Content-Type': 'application/json'
    }
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Ошибка запроса: ' + response.statusText);
      }
      return response.json();
    })
    .then(data => {
      console.log(data);
      // Удаляем весь div, содержащий задачу, из DOM
      var taskColumn = document.querySelector(`[data-task-id="${taskId}"]`).parentNode;
      if (taskColumn) {
        taskColumn.remove();
      }
      // Закрыть модальное окно
      var taskModal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
      taskModal.hide();
    })
    .catch(error => console.error('Ошибка:', error));
});



