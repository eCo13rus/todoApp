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
        var newTaskHtml = `
        <div class="col-md-3 text-center mb-3">
          <div class="card" style="width: 18rem;" data-task-id="${task.id}">
            <ul class="list-group list-group-flush">
              <li class="list-group-item"><strong>Название:</strong> ${task.name}</li>
              <li class="list-group-item"><strong>Заголовок:</strong> ${task.title}</li>
              <li class="list-group-item"><strong>Описание:</strong> ${task.description}</li>
            </ul>
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

      // Извлекаем данные из элементов списка
      var taskName = card.querySelector('li:nth-child(1)').textContent.replace('Название: ', '');
      var taskTitle = card.querySelector('li:nth-child(2)').textContent.replace('Заголовок: ', '');
      var taskDescription = card.querySelector('li:nth-child(3)').textContent.replace('Описание: ', '');

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
        _method: 'PUT',
        name: taskName,
        title: taskTitle,
        description: taskDescription,
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (task) {
        var cardToUpdate = $(`[data-task-id="${task.id}"]`);

        // Обновляем содержимое карточки
        cardToUpdate.find('li:nth-child(1)').html(`<strong>Название:</strong> ${task.name}`);
        cardToUpdate.find('li:nth-child(2)').html(`<strong>Заголовок:</strong> ${task.title}`);
        cardToUpdate.find('li:nth-child(3)').html(`<strong>Описание:</strong> ${task.description}`);

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
      var taskColumn = document.querySelector(`[data-task-id="${taskId}"]`).parentNode;
      if (taskColumn) {
        taskColumn.remove();
      }
      var taskModal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
      taskModal.hide();
    })
    .catch(error => console.error('Ошибка:', error));
});




