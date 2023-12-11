// Генерация HTML Карточек
function createTaskCard(task) {
  return `
    <div class="col-md-3 text-start">
      <div class="card mb-4 ms-4" style="width: 15rem; height: 200px" data-task-id="${task.id}">
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><strong>Создал:</strong> ${task.name}</li>
          <li class="list-group-item"><strong>Кому:</strong> ${task.title}</li>
          <li class="list-group-item" data-full-description="${task.description}"><strong>Описание:</strong> ${task.short_description}</li>
        </ul>
      </div>
    </div>`;
}


// Пагинация
function loadTasks(page = 1, callback = null) {
  $.ajax({
    url: `?page=${page}`,
    type: 'get',
    dataType: 'json',
    success: function (data) {
      $('#tasksContainer').html('');
      data.tasks.forEach(task => {
        $('#tasksContainer').append(createTaskCard(task));
      });
      $('#pagination').html(data.pagination);
      if (callback) callback(data);
    }
  });
}

document.addEventListener('DOMContentLoaded', function () {
  loadTasks();
});


$(document).on('click', '.pagination a', function (event) {
  event.preventDefault();
  var page = $(this).attr('href').split('page=')[1];
  loadTasks(page);
});



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
        // Перезагрузить текущую страницу пагинации после добавления задачи
        loadTasks(undefined, function (data) {
          var currentPage = $('.pagination .active span').text();
          var tasksPerPage = 8; // Предполагается, что у тебя 8 задач на странице
          var totalTasks = data.tasks.length + 1; // Учитываем только что добавленную задачу

          // Проверяем, нужно ли перейти на новую страницу
          if (totalTasks > tasksPerPage) {
            var newPage = parseInt(currentPage) + 1;
            loadTasks(newPage);
          }
        });

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
      const taskColumn = document.querySelector(`[data-task-id="${taskId}"]`).parentNode;
      if (taskColumn) {
        taskColumn.remove();
      }
      const taskModal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
      taskModal.hide();

      // Перезагружаем текущую страницу пагинации, чтобы обновить список задач
      var currentPage = parseInt($('.pagination .active span').text());
      var tasksCount = $('#tasksContainer').children().length;
      if (tasksCount <= 1 && currentPage > 1) {
        // Если на странице осталась одна или нет задач, и это не первая страница, загружаем предыдущую
        loadTasks(currentPage - 1);
      } else {
        // В противном случае просто обновляем текущую страницу
        loadTasks(currentPage);
      }
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
$(document).ready(function () {
  $('#tasksContainer').on('click', '.card', function () {
    const card = $(this);
    const taskId = card.data('task-id');
    const taskName = card.find('li:nth-child(1)').text().replace('Создал: ', '');
    const taskTitle = card.find('li:nth-child(2)').text().replace('Кому: ', '');
    const taskDescription = card.find('li:nth-child(3)').data('full-description');

    $('#editTaskId').val(taskId);
    $('#editTaskName').val(taskName);
    $('#editTaskTitle').val(taskTitle);
    $('#editTaskDescription').val(taskDescription);

    const taskModal = new bootstrap.Modal($('#taskModal'));
    taskModal.show();
  });
});





// чтения данных из data-tasks
document.addEventListener('DOMContentLoaded', function () {
  var tasksContainer = document.getElementById('tasksContainer');
  var tasksData = tasksContainer.getAttribute('data-tasks');

  if (tasksData) {
    var tasks = JSON.parse(tasksData);
    if (Array.isArray(tasks)) {
      tasks.forEach(function (task) {
        $('#tasksContainer').append(createTaskCard(task));
      });
    }
  }
});

