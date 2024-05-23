import os
import json
import threading
from datetime import date
from yt_dlp import YoutubeDL


def download_and_display():

    today = date.today()

    ydl_opts = {
        "outtmpl": f"./webroot/videos/movies/%(id)s/%(id)s.%(ext)s",
    }

    ydl = YoutubeDL(ydl_opts)

    filename = './webroot/datas/data_tiktok_'+ today.strftime("%Y%m%d") +'.json'
    f = open(filename)
    datas = json.load(f)
    f.close()

    for data in datas:
        try:
            author = data["author"]
            id = data["id"]
            video_url = "https://www.tiktok.com/@"+author+"/video/"+id
            with ydl:
                ydl.download([video_url])
        except Exception as ex:
            print(ex)


thread = threading.Thread(target=download_and_display)
thread.start()
