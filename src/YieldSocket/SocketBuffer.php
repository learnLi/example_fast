<?php


namespace Administrator\ExampleFast\YieldSocket;


interface SocketBuffer
{
    // 最大发送数据大小 1Mb
    const MaxSendBuffer = 1048576;

    // 1 kb
    const BaseBufferByte = 1024;

    // 10mb
    const PackageBuffet = 10485760;
}