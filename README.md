## Commands

### Audio 
```
artisan audio:book-download {jsonFile} {name}
```
Downloads an audiobook from a json file
 - jsonFile: The json file containing the audiobook information
 - name: The name of the audiobook, used when naming files

```
artisan audio:merge {directory} {output}
```
Merges all audio files in a directory into a single file
 - directory: The directory containing the audio files
 - output: The output file

```
artisan audio:khdownload {album} {format=flac}
```
Downloads an album from [khinsider](https://downloads.khinsider.com)
 - album: The album to download (Will be the last part of the URI)
 - format: The format to download the album in (Defaults to flac)

----
Download based commands will provide the output as a series of `wget` commands.
To run them inline pipe the output to `bash` or save them to a file and run it.

eg: 
```
artisan audio:khdownload super-mario-bros flac | sh
```
