# Batch Job component for PHP

The component should easy up handling of batch job processes. 
It should be independent how the batch job is executed (url call, process forking, think about something else).
Furthermore, the component defines the manager and the batch job itself. The manager takes care to start the batch job while the batch job implements the real logic.
