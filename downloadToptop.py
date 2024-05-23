import json
import threading
from tkinter import Tk, Label, Entry, Button, Text, filedialog, END
from yt_dlp import YoutubeDL

filename = ""
download_folder = r""

def browse_file():
    global filename
    filename = filedialog.askopenfilename(title="Select a file")
    if filename:
        entry_text.delete(0, END)
        entry_text.insert(0, filename)

def browse_folder():
    global download_folder
    download_folder = filedialog.askdirectory(title="Select download folder")
    if download_folder:
        entry_folder.delete(0, END)
        entry_folder.insert(0, download_folder)

def display_text():
    global filename, download_folder

    if filename != "" and download_folder != "":
        ydl_opts = {
            "outtmpl": f"{download_folder}/%(title)s.%(ext)s",
        }
        ydl = YoutubeDL(ydl_opts)


        filename = './webroots/datas/data_tiktok_20231207.json'

        def download_and_display():
            f = open(filename)
            # returns JSON object as
            # a dictionary
            datas = json.load(f)
            f.close()
            # Iterating through the json
            # list
            for data in datas:
                try:
                    author = data["author"]
                    id = data["id"]
                    video_url = "https://www.tiktok.com/@"+author+"/video/"+id
                    with ydl:
                        result = ydl.download([video_url])
                        text_view.insert(END, "downloaded: "+video_url+"\n")
                except Exception as ex:
                    text_view.insert(END, str(ex) + "\n")
            text_view.insert(END, "Completed.\n")

        thread = threading.Thread(target=download_and_display)
        thread.start()

root = Tk()
root.title("TopTop Download")

label_text = Label(root, text="Enter file path:")
label_text.grid(row=0, column=0)

entry_text = Entry(root, width=50)
entry_text.grid(row=0, column=1)

browse_button = Button(root, text="Browse", command=browse_file)
browse_button.grid(row=0, column=2)

label_folder = Label(root, text="Choose download folder:")
label_folder.grid(row=1, column=0)

entry_folder = Entry(root, width=50)
entry_folder.grid(row=1, column=1)

browse_folder_button = Button(root, text="Browse Folder", command=browse_folder)
browse_folder_button.grid(row=1, column=2)

text_view = Text(root, height=15, width=50)
text_view.grid(row=2, columnspan=3)

display_button = Button(root, text="Download Videos", command=display_text)
display_button.grid(row=3, columnspan=3)

root.mainloop()