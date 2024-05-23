from moviepy.editor import VideoFileClip, concatenate_videoclips,CompositeVideoClip
import random

# path
video_paths = [
    "./webroot/videos/movies/6965847381757791489/6965847381757791489.mp4", 
    "./webroot/videos/movies/7106731758648970523/7106731758648970523.mp4", 
    "./webroot/videos/movies/7120128846069812506/7120128846069812506.mp4"
]

# create list
clips = [VideoFileClip(path) for path in video_paths]
print(clips)

final_clip = CompositeVideoClip(clips,size=(720,460))

final_clip.write_videofile("output.mp4")

