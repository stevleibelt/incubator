# Message Broker

This repository is comparing different message brokers and libraries for the following usecase.

* disaster save (no single point of failure)
* multiple creator and multiple consumer
* creator can push a bunch/chunk of messages
* consumer can pull a bunch/chunk of messages
* ack on both sides if a message was processed
* nothing gets lost when there is a blackout
* transparent (see what is inside a queue)
* easy to use
* fast, fucking fast
