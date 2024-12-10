import sys
import json
from PyQt5.QtCore import QThread, pyqtSignal
from PyQt5.QtWidgets import QApplication, QWidget, QLabel, QLineEdit, QPushButton, QVBoxLayout, QMessageBox
from yt_dlp import YoutubeDL

FULLBASE = '/Users/huy.nguyen/project/T/tfy-chan/webroot'

class DownloadThread(QThread):
    download_progress = pyqtSignal(int)
    finished = pyqtSignal()
    error_occurred = pyqtSignal(str)

    def __init__(self, movie_id):
        super().__init__()
        self.movie_id = movie_id

    def run(self):

        def progress_hook(d):
            if d['status'] == 'downloading':
                percent_str = d.get('_percent_str', '').strip('%').strip()
                try:
                    progress = float(percent_str)
                    if progress >= 0 and progress <= 100:
                        self.download_progress.emit(int(progress))
                    else:
                        # Handle invalid progress value
                        pass
                except ValueError:
                    # Handle case where percent_str is not a valid number
                    pass
            elif d['status'] == 'finished':
                self.finished.emit()
            elif d['status'] == 'error':
                error_message = d.get('error', 'Unknown error occurred.')
                self.error_occurred.emit(error_message)
        
        ydl_opts = {
            "outtmpl": f"{FULLBASE}/videos/movies/%(id)s/%(id)s.%(ext)s",
            "format": "best",
            "progress_hooks": [progress_hook]
        }
        ydl = YoutubeDL(ydl_opts)
        # video_url = f'https://www.facebook.com/watch?v={self.movie_id}'
        video_url = f'https://www.facebook.com/reel/{self.movie_id}'
        try:
            with ydl:
                ydl.download([video_url])
                self.finished.emit()
        except Exception as e:
            self.error_occurred.emit(str(e))
            
class DownloadMovieFacebook(QWidget):
    def __init__(self):
        super().__init__()
        self.initUI()

    def initUI(self):
        self.setWindowTitle('Nhập id video trên Facebook')
        self.setGeometry(100, 100, 300, 200)

        self._input = QLineEdit()
        self._button = QPushButton('Download video')
        self._button.clicked.connect(self.start_download)
        self.progress_label = QLabel('Đang xử lý: 0%')

        vbox = QVBoxLayout()
        vbox.addWidget(self._input)
        vbox.addWidget(self._button)
        vbox.addWidget(self.progress_label)
        self.setLayout(vbox)
    
    def check_movie_id_exists(self):
        try:
            f = open(f'{FULLBASE}/videos/json/fb_movie_ids.json')
            data = json.load(f)

            movie_ids = data.get('movie_ids', [])
            if self.mid in movie_ids:
                return True
            else:
                movie_ids.append(self.mid)
                data['movie_ids'] = movie_ids

            with open(f'{FULLBASE}/videos/json/fb_movie_ids.json', 'w') as f:
                json.dump(data, f, indent=4)
            return False
        except Exception as e:
            print(f"Error checking movie ID: {e}")
            return False

    def start_download(self):
        movie_id = self._input.text()
        self.mid = movie_id

        if (self.check_movie_id_exists()):
            self.progress_label.setText('Movie ID đã tồn tại!')
        else:
        
            self.progress_label.setText('Đang xử lý: 0%')
            self.thread = DownloadThread(movie_id)
            self.thread.download_progress.connect(self.update_progress)
            self.thread.finished.connect(self.download_finished)
            self.thread.error_occurred.connect(self.handle_error)
            self.thread.start()

    def update_progress(self, percent):
        self.progress_label.setText(f'Đang xử lý: {percent}%')

    def download_finished(self):
        self.thread.quit()
        self.thread.wait()
        self.progress_label.setText(f'Tải thành công!(ID: {self.mid})')

    def handle_error(self, error_message):
        self.thread.quit()
        self.thread.wait()
        QMessageBox.critical(self, 'Lỗi', f'Tải video thất bại: {error_message}')

if __name__ == '__main__':
    app = QApplication(sys.argv)
    window = DownloadMovieFacebook()
    window.show()
    sys.exit(app.exec_())


# 3272205526420054
# 433739129496512