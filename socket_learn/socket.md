
> 查看tcp端口指令

```shell
# netstat -ano | findstr '8880'
```

----------------------------------

> Server Demo

简单的socket服务器（当前并发量只有1）

```php
<?php

$port = 8880;
$host = "127.0.0.1";
$protocol = 'tcp://';
$socket = stream_socket_server($protocol . $host . ":" . $port, $errno, $err_message);
stream_set_blocking($socket, false);

if (!$socket) {
    echo "$err_message ($errno)<br />\n";
} else {
    fwrite(STDOUT, "socket server listen on port: {$port}" . PHP_EOL);
    
    while ($conn = stream_socket_accept($socket)) {
        $data = stream_get_contents($conn, 1024);
        echo "{ 当前有请求进入... } \n";
        echo "{ 读取的数据 $data } \n";
        fwrite($conn, 'The local time is ' . date('Y-m-d H:i:s') . "\n");
        fclose($conn);
    }
    fclose($socket);
}
```


> Client Demo

简单的客户端

```php
<?php

$port = 8880;
$host = "127.0.0.1";
$protocol = 'tcp://';
$socket = stream_socket_server($protocol . $host . ":" . $port, $errno, $err_message);

if (!$socket) {
    echo "$err_message ($errno)<br />\n";
} else {
    fwrite($socket, "this is client request");
    while (!feof($socket)) {
        echo fgets($socket, 1024);
    }
    fclose($socket);
}

```


## 多进程编程
>   pcntl扩展不支持windows系统



## I/O复用

涉及知识：阻塞/非阻塞，同步/异步，I/O多路复用，轮询，epoll

    1. 阻塞/非阻塞 :
        这两个概念是针对 IO 过程中进程的状态来说的，阻塞
        IO 是指调用结果返回之前，当前线程会被挂起；相反，
        非阻塞指在不能立刻得到结果之前，该函数不会阻塞当
        前线程，而会立刻返回；

    2. 同步/异步 : （针对方法的处理结果）
        这两个概念是针对调用如果返回结果来说的，所谓同步，
        就是在发出一个功能调用时，在没有得到结果之前，该
        调用就不返回；相反，当一个异步过程调用发出后，调
        用者不能立刻得到结果，实际处理这个调用的部件在完
        成后，通过状态、通知和回调来通知调用者。
    
    3. I/O多路复用 :
        阻塞与非阻塞：在介绍IO复用技术之前，先介绍一下阻
        塞和非阻塞，在我们前几节的WEB服务器中，调用
        socket_accept函数会使整个进程阻塞，直到有新连
        接，操作系统才唤醒进程继续执行。而非阻塞模式, 
        stream_socket_accept的行为就不一样了，如果没
        有新连接，不会阻塞进程，而是马上返回false；














































>   stream_socket_** 函数的使用方法


`stream_set_blocking`: 设置socket资源阻塞模式，阻塞or非阻塞。

`stream_socket_server`: 创建一个socket服务套接字（socket服务）。

`stream_socket_accept`: 接收一个socket服务连接，返回一个 resource 对象。

`stream_get_contents` : 获取资源流的数据


