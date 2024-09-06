@include('includes.calendar-modal')

<style>
    .taskNotificationListHeader a{
        font-size:12px;
        padding-left:3px;
        text-wrap: wrap;
    }
    .taskNotificationListHeader a:hover{
        background-color:#17a2b8;
        color:#ffffff !important;
    }
    .taskNotificationListHeader a:active{
        background-color:#ffffff;
        color:#17a2b8 !important;
    }
    .taskNotificationListHeader ~a:hover {
        background-color:#ffffff;
        color:#17a2b8 !important;
    }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">

        <li class="nav-item">
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="Calender" data-toggle="modal"
                data-target="#calendarModal">
                <i class="fa fa-calendar"
                    style="font-size: 21px;color: #7f7f7f;margin-top: 7px;margin-right: 10px;"></i>
            </a>
        </li>


        <li class="nav-item dropdown">
            <a data-bs-toggle="tooltip" data-bs-placement="right" title="Notifiction" class="nav-link dropdown-toggle"
                href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="fa fa-bell" style="font-size:21px"></i>
                <span style="top:4px; position:absolute; left: 16px;" class="badge badge-pill badge-danger"
                    id="notificationCount">{{ $notifications->where('status', 'new')->where('notification_to', Auth::user()->id)->count() }}</span>
            </a>
            @if ($notifications)
                <div style="display:none;" class="dropdown-menu notification-dd-container dropdown-menu-right"
                    aria-labelledby="notificationDropdown" id="notificationDropdownMenu">
                    @foreach ($notifications->sortByDesc('created_at') as $notification)
                        @if (Auth::user()->id == $notification->notification_to)
                            <a href="{{ url($notification->url) }}"
                                class="dropdown-item {{ $notification->status == 'read' ? '' : 'unread' }}">
                                <div
                                    class="notification-item {{ $notification->status == 'read' ? 'its-read' : 'its-new' }}">
                                    <p class="notification-title">{{ $notification->text }}</p>
                                    <p class="notification-created_at">{{ $notification->created_at }}</p>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
        </li>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="taskNotificationDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-tasks"></i>
                <span class="badge badge-danger" id="taskNotificationCount">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="taskNotificationDropdown" style="top:80%;">
                <h6 class="dropdown-header" style="padding-left:3px; text-align:left; font-weight:bold;">Notifications</h6>
                <div id="taskNotificationList" class="taskNotificationListHeader">
                </div>
                <div class="dropdown-divider"></div>
                <a style="font-size:12px;" class="dropdown-item text-center " href="{{ route('tasks.index') }}">View All Tasks</a>
            </div>
        </li>


        <li class="nav-item dropdown">
            @php
                $photo = Auth::user()->photo ?? 'assets/images/profile/male.png';
            @endphp
            <a class="nav-link dropdown-toggle profile-pic login_profile p-1" data-toggle="dropdown" href="#">
                <img src="{{ asset($photo) }}" alt="user-img" width="36" class="img-circle">
                <b id="ambitious-user-name-id" class="hidden-xs">{{ strtok(Auth::user()->name, ' ') }}</b>
                <span class="caret"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width: 200px !important; left:-150px; top:95%;">
                <div class="dw-user-box">
                    <div class="u-img"><img src="{{ asset($photo) }}" alt="user" /></div>
                    <div class="u-text">
                        <h4 style="font-size:13px;">{{ Auth::user()->name }}</h4>
                        <p class="text-muted custom-padding-bottom-5" style="font-size:11px;">
                            {{ \Illuminate\Support\Str::limit(Auth::user()->email, 17) }}</p>
                        <a href="{{ route('profile.view') }}"
                            class="btn btn-rounded btn-danger btn-sm">{{ __('View Profile') }}</a>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="{{ route('profile.view') }}" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> {{ __('My Profile') }}
                </a>
                <a href="{{ route('profile.setting') }}" class="dropdown-item">
                    <i class="fas fa-cogs mr-2"></i> {{ __('Account Setting') }}
                </a>
                <a href="{{ route('profile.password') }}" class="dropdown-item">
                    <i class="fa fa-key mr-2"></i> {{ __('Change Password') }}
                </a>
                <div class="dropdown-divider"></div>
                <a id="header-logout" href="{{ route('logout') }}" class="dropdown-item"><i
                        class="fa fa-power-off mr-2"></i> {{ __('Logout') }}</a>
                <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
<script src="{{ asset('assets/js/custom/layouts/header.js') }}"></script>
<script>
    const markAllNotificationsAsReadUrl = "{{ route('notifications.readAll') }}";
    document.addEventListener('DOMContentLoaded', () => {
        const notificationDropdown = document.getElementById('notificationDropdown');
        const dropdownMenu = document.getElementById('notificationDropdownMenu');

        notificationDropdown.addEventListener('click', async () => {
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';

            if (dropdownMenu.style.display === 'block') {
                await markAllNotificationsAsRead();
                loadNotifications();
            }
        });

        document.addEventListener('click', handleDocumentClick);
    });

    async function loadNotifications() {
        try {
            const response = await fetch('/api/notifications', {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                }
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const notifications = await response.json();
            const dropdownMenu = document.getElementById('notificationDropdownMenu');
            dropdownMenu.innerHTML = '';

            let unreadCount = 0;

            notifications.sort((a, b) => new Date(b.created_at) - new Date(a.created_at)).forEach(notification => {
                if (notification.status === 'new') {
                    unreadCount++;
                }

                const item = document.createElement('div');
                item.classList.add('notification-item');
                if (notification.status === 'new') {
                    item.classList.add('its-new');
                }

                item.innerHTML = `
                <a href="${notification.url}" class="notification-link" data-id="${notification.id}">
                    <div class="notification-item">
                        <p class="notification-title">${notification.text}</p>
                        <p class="notification-created_at">${notification.created_at}</p>
                    </div>
                </a>
            `;
                dropdownMenu.appendChild(item);
            });

            document.getElementById('notificationCount').textContent = unreadCount;
            attachNotificationClickEvents();
        } catch (error) {
            console.error('Error fetching notifications:', error);
        }
    }

    function attachNotificationClickEvents() {
        document.querySelectorAll('.notification-link').forEach(link => {
            link.addEventListener('click', async (event) => {
                event.preventDefault();
                const notificationId = event.currentTarget.getAttribute('data-id');
                const url = event.currentTarget.getAttribute('href');
                await markNotificationAsRead(notificationId);
                window.location.href = url;
            });
        });
    }

    async function markNotificationAsRead(notificationId) {
        try {
            const response = await fetch('/dental/notifications/read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    id: notificationId
                })
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();
            if (result.success) {
                const notificationElement = document.querySelector(
                    `.notification-link[data-id="${notificationId}"] .notification-item`);
                notificationElement.classList.remove('its-new');
                notificationElement.classList.add('its-read');
            }
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    }

    async function markAllNotificationsAsRead() {
        try {
            const response = await fetch(markAllNotificationsAsReadUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                }
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();
            if (result.success) {
                document.querySelectorAll('.notification-link .notification-item').forEach(notificationElement => {
                    notificationElement.classList.remove('its-new');
                    notificationElement.classList.add('its-read');
                });

                document.getElementById('notificationCount').textContent = 0;
            }
        } catch (error) {
            console.error('Error marking all notifications as read:', error);
        }
    }

    function handleDocumentClick(event) {
        const notificationDropdown = document.getElementById('notificationDropdown');
        const dropdownMenu = document.getElementById('notificationDropdownMenu');

        if (!notificationDropdown.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = 'none';
        }
    }
</script>
<script>
    $(document).ready(function() {
        // Function to fetch task notifications
       function fetchTaskNotifications() {
    $.ajax({
        url: '{{ route('taskNotifications.fetch') }}',
        type: 'GET',
        success: function(data) {
            let notifications = data.notifications;
            // Sort notifications by date in descending order
            notifications.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            let notificationCount = data.countTaskNotification;
            $('#taskNotificationCount').text(notificationCount);
            let notificationList = '';
            notifications.forEach(notification => {
                let notificationClass = notification.status === 'new' ?
                    'font-weight-bold' : 'text-muted';
                notificationList += `
                    <a class="dropdown-item ${notificationClass}" id="notification-${notification.id}" href="${notification.url}" onclick="handleNotificationClick(event, ${notification.id})">
                        ${notification.text}
                    </a>`;
            });
            $('#taskNotificationList').html(notificationList);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching notifications:', error);
        }
    });
}


        // Function to mark task notification as read
        window.markTaskNotificationAsRead = function(notificationId) {
            $.ajax({
                url: '{{ route('taskNotifications.markAsRead') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    notificationId: notificationId
                },
                success: function() {
                    // Change the appearance of the read notification
                    $('#notification-' + notificationId).removeClass('font-weight-bold')
                        .addClass('text-muted');
                    // Update the notification count
                    updateNotificationCount();
                },
                error: function(xhr, status, error) {
                    console.error('Error marking notification as read:', error);
                }
            });
        };

        // Function to update the notification count
        function updateNotificationCount() {
            let currentCount = parseInt($('#taskNotificationCount').text());
            if (!isNaN(currentCount) && currentCount > 0) {
                $('#taskNotificationCount').text(currentCount - 1);
            }
        }

        // Function to handle notification click
        window.handleNotificationClick = function(event, notificationId) {
            event.preventDefault(); // Prevent the default link behavior
            // Redirect to the notification URL
            window.location.href = $(`#notification-${notificationId}`).attr('href');
            // Mark the notification as read
            markTaskNotificationAsRead(notificationId);
        };


        fetchTaskNotifications();
    });
</script>


