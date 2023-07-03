<x-mail::message>
    # @lang("Reminder") : @lang("task to do in the todolist app")

    @lang("Hello") {{$user}},

    @lang("We remind you that a task is planned in your ToDo List application. Here are the details of the task") :

    - @lang("Task title") : {{$title}}
    - @lang("Task date") : {{$date}}
    - @lang("Task time") : {{$time}}
    - @lang("Task description") : {{$description}}

    @lang("You have") {{$diff}}H @lang("left to complete this task. We encourage you to complete it on time.")

    @lang("If you have any questions or concerns, please do not hesitate to contact us.")

    @lang("Cordially"),<br>
    Dev Master
</x-mail::message>
